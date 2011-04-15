<?php

/**
 * AsteriskCdr
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */

class AsteriskCdr extends BaseAsteriskCdr
{
    private $resident = NULL; // holds the resident associated with the call use getResident()
    private $rate     = NULL;


    /*
     * Gets the resident associated with the call. This function will fetch the
     * resident from the database only if neccesary.
     */
    private function getResident() {
        if( ! ($this->resident instanceof Residents)) {
            $roomNumber = $this->getRoomNumber();

            /* Find the user living in this room at the calldate */
            $residentsTable = Doctrine_Core::getTable('Residents');
            $this->resident = $residentsTable->findByRoomNo($roomNumber,$this->calldate);
        }

        return $this->resident;
    }

    private function getRoomNumber() {
        // Extract the room number from the source.
        // The expression matches analog telephones were
        // $this->src is like 004972186951NNN as well as SIP phones which
        // have $this->src = "SIP/1NNN" where NNN is the room number.
        if($this->isIncomingCall()) {
            return substr($this->dst, -3);
        } else {
            return substr($this->src, -3);
        }
    }

    /**
     * Checks if there's a representation of the cdr in the calls table
     * @return bool
     */
    public function isBilled() {
        $callsResult = Doctrine_Query::Create()
            ->from('Calls')
            ->where('asterisk_uniqueid = ?', $this->uniqueid)
            ->execute();
        $count = $callsResult->count();
        if($count != 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if the calls origin is a public room (common room, bar, ...)
     * Configure the rooms in ProjectConfiguration.class.php 'hekphonePublicRooms'
     * @return bool
     */
    private function isFromPublicRoom(){
        return in_array($this->getRoomNumber(), sfConfig::get('hekphonePublicRooms'));
    }

    /**
     * Checks wheter the cdr represents a free call. Determined by the userfield
     * @return bool
     */
    private function isFreeCall() {
        if($this->userfield == 'free' || $this->dst[0] == '*') {
            return true;
        } else {
            return false;
        }
    }

    private function isInternalCall() {
      if($this->userfield ==  sfConfig::get('asteriskInternalUserfield')) {
        return true;
      } else {
        return false;
      }
    }

    private function isIncomingCall() {
        if(sfConfig::get('asteriskIncomingContext') == $this->dcontext) {
          return true;
        } else {
          return false;
        }
    }

    /**
     * Returns the destination number as string conformed to the prefixes
     * stored in the Prefixes relation e.g. 072186951 results in 00497218695.
     * It's supposed to work on outgoing calls on incoming calls it returns
     * $destination unmodified.
     *
     * Free calls specific to our Asterisk setup
     * (RSH: 0313NNN -> 00497211306NNN) are also taken into account
     * This is "hardcoded" - which is bad - and should be moved to a config variable.
     *
     * @throws Exception
     * @return string
     */
    private function getFormattedDestination() {
        if ($this->isIncomingCall()) {
            return $this->dst;
        }

        if(strpos($this->channel, 'SIP') === false) {
            return $this->getFormattedDestinationOfCallFromAnalogPhone();
        } else {
            return $this->getFormattedDestinationOfCallFromSipPhone();
        }
    }

    private function getFormattedDestinationOfCallFromSipPhone()
    {
        if($this->dst[0] == '0')
        {
            // calls from sip phones have an additional 0 preceeding the number
            // if they have been routed through the normal PSTN
            $destination = substr($this->dst, 1);
        }
        elseif (substr($this->dst, 0, 2) == '60')
        {
            // they have an additional 60 if they are routed through voip
            $destination = substr($this->dst, 2);
        } else
        {
            $destination = $this->dst;
        }

        /* Conform $this->dst to  "0049+prefix+number" */
         if ( substr($destination,0,1) == '3' ) {
             // free call to RSH
             $destination = '00497211306' . substr($destination,1);
         } elseif ( substr($destination,0,1) == '5' ) {
             // free call to ABH
             $destination = '00497211307' . substr($destination,1);
         } elseif ( substr($destination,0,2) == '00') {
             // calls with country-prefix 00
             $destination = $destination;
         } elseif ( substr($destination,0,1) == '0' ) {
             // call with city prefix 0
             $destination = '0049' . substr($destination,1);
         } elseif ( substr($destination,0,1) == '*') {
             // free call using  *721
             $destination = '0049' . substr($destination,1);
         } elseif ( substr($destination,0,2) == '60') {
             // voip-call. strip the "60"
             $destination = '0049' . substr($destination,1);
         } elseif ( substr($destination,0,1) > 0 ) {
             // local call without any prefix
             $destination = '0049721' . $destination;
         } else {
             throw new Exception("Unable to match dialed number to any pattern");
         }

         return $destination;
    }

    private function getFormattedDestinationOfCallFromAnalogPhone()
    {
        // VoIP calls from analog telephones are prefixed with 03140. Cut this off.
        if(substr($this->dst, 0, 5) == '03140') {
            $destination = substr($this->dst, 5);
        } else {
            $destination = $this->dst;
        }

        /* Conform $this->dst to  "0049+prefix+number" */
        if ( substr($destination,0,7) == '8695020' ) {
             //It's a free call using *721
             $destination = '0049' . substr($destination,7);
         } elseif ( substr($destination,0,4) == '0313' ) {
             // It's a free call to RSH
             $destination = '00497211306' . substr($destination,4);
         } elseif ( substr($destination,0,4) == '0315' ) {
             // It's a free call to ABH
             $destination = '00497211307' . substr($destination,4);
         } elseif ( substr($destination,0,2) == '00') {
             $destination = $destination;
         } elseif ( substr($destination,0,1) == '0' ) {
             $destination = '0049' . substr($destination,1);
         } elseif ( substr($destination,0,1) > 0 ) {
             $destination = '0049721' . $destination;
         } else {
             throw new Exception("Unable to match dialed number to any pattern");
         }

         return $destination;
    }

    /**
     * Creates an entry in the calls table for the Cdr. The costs are calculated
     * and the call is assigned to a user.
     *
     * @return $call Calls
     */
    private function createCallsEntry()
    {
        $destinationToBill = $this->getFormattedDestination();
        $destinationToSave = $this->shortenDestination();

        /* Create an entry in the calls table */
        $call = New Calls();
        $call->resident     = $this->getResident()->id;
        $call->extension    = 1000+$this->getRoomNumber();
        $call->date         = $this->calldate;
        $call->duration     = $this->billsec;
        $call->destination  = $destinationToSave;
        $call->asterisk_uniqueid = $this->uniqueid;
        $call->rate   = $this->getRate()->getId();
        $call->charge = $this->getRate()->getCharge($this->billsec);

        $call->save();

        return $call;
    }

    public function getRate()
    {
        if( ! ($this->rate instanceof Rates)) {
            $ratesTable = Doctrine_Core::getTable('Rates');
            if($this->isFreeCall()) {
                $this->rate = $ratesTable->find('9999');
            } else {
                $provider = $this->userfield;
                $this->rate = $ratesTable->findByNumberAndProvider(substr($this->getFormattedDestination(),2), $provider, $this->calldate);
            }
        }

        return $this->rate;
    }

    /*
     * Replace last 3 digits of the destination with xxx
     * if $resident->shortened_itemized_bill is true.
     */
    private function shortenDestination() {
        if ( $this->getResident()->shortened_itemized_bill) {
            return substr($this->getFormattedDestination(), 0, -3) . 'xxx';
        } else {
            return $this->getFormattedDestination();
        }
    }

    /**
     * Deletes any entry in the calls table corresponding to the cdr. And executes
     * bill() (creates the entry again).
     */
    public function rebill() {
        // Delete old entry if it exists
        Doctrine_Query::create()
            ->delete('Calls')
            ->where('asterisk_uniqueid = ?', $this->uniqueid)
            ->execute();

        //bill cdr again
        return $this->bill();
    }

    /**
     * Calculates the cost of an AsteriskCdr-Record (a finished call), creates
     * an record in the Calls table. Returns true on succes otherwise throws exception.
     * @throws Exception
     * @return bool
     */
    public function bill() {
        /* warn and abort if the call is already billed and no rebilling is whished */
        if($this->isBilled()) {
            throw New Exception("The cdr has already been billed");
        }
        /* only bill outgoing calls no incoming calls*/
        if($this->isIncomingCall()) {
            throw new Exception("Trying to bill an incoming call");
        }
        /* and no internal calls*/
        if($this->isInternalCall()) {
            return false;
        }
        /* only calls that have been answered */
        if($this->disposition != 'ANSWERED') {
            return false;
        }
        /* don't try to bill free calls from public rooms */
        if($this->isFromPublicRoom() && $this->isFreeCall()) {
            return false;
        }
        /* warn if trying to bill outgoing non-free calls of locked users */
        if( ! in_array($this->dcontext, sfConfig::get('asteriskUnlockedPhonesContexts')) && ! $this->isFreeCall()) {
            throw New Exception("[security warning] locked user made an outgoing call");
        }
        /* check if the call originated from a public room and exit with an error if it's non-free */
        if($this->isFromPublicRoom() && ! $this->isFreeCall()) {
            throw new Exception("Non-free call from public room: ". $this->getRoomNumber());
        }

        $callsEntry = $this->createCallsEntry();

        $this->getResident()->checkIfBillLimitIsAlmostReached();

        //Log some details.
        // FIXME: using echo in a model is bad. replace it by correct logging.
        echo "[uniqueid='" . $this->uniqueid . "'][info] Billed call. Extension:" . $callsEntry->extension
         . "; Cost: ".round($callsEntry->charges,2) . "ct" . PHP_EOL;

        return true;
    }
}