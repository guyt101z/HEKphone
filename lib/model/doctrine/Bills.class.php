<?php

/**
 * Bills
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Bills extends BaseBills
{
    /**
     * Get all calls associated with the bill.
     */
    public function getCalls()
    {
        return Doctrine_query::create()
               ->from('Calls c')
               ->addWhere('c.bill = ?', $this->id)
               ->execute();
    }


    /**
     * For one bill the content for the *.ctl file for the dtaus program is returned.
     * @param $start Start date for bill period
     * @param $end End date for the bill period
     * @return string The string of the dtaus entry or an empty string if the dtaus entry could not be generated
     */
    public function getDtausEntry()
    {
    	$dtausEntry = null;

    	//If there is not the required information given to generate the dtaus entry for a resident an empty string is returned
    	if ($this['Residents']['last_name']  == null || $this['Residents']['account_number'] == null || $this['Residents']['bank_number'] == null || $this['amount'] == 0)
    	{    		
    		throw New Exception("No dtaus entry for bill " . $this['id'] . " with amount " . $this['amount'] . " EUR");
    	}
    	else
    	{
            $dtausEntry = "{
  Name	" . $this['Residents']['last_name'] . "
  Konto	" . $this['Residents']['account_number'] ."
  BLZ	" . $this['Residents']['bank_number'] . "
  Transaktion	Einzug
  Betrag	" . $this['amount']."
  Zweck	" . sfConfig::get("transactionName")."
  myName	" . sfConfig::get("hekphoneName")."
  myKonto	" . sfConfig::get("hekphoneAccountnumber")."
  myBLZ	" . sfConfig::get("hekphoneBanknumber")."
  Text	" . $this['billingperiod_start'] . " BIS " . $this['billingperiod_end'] . "
}
";
     	}

    return $dtausEntry;
    }

    /**
     * A string with all itemized Bill entries for each related call of the bill is returned
     * @return string
     */
    public function getItemizedBill()
    {
    	$itemizedBill = str_pad('Datum',21)
        		        .str_pad('Dauer(sec)',12)
                        .str_pad('externe Nummer',22)
                        .str_pad('Kosten (ct)',14)
                        .str_pad('Rate',18)."\n";

        foreach($this['Calls'] as $call)
        {
            $itemizedBill .= $call->getItemizedBillEntry()."\n";
  	    }
        
        return $itemizedBill;
    }

     /**
     * Send the bill via Email to the resident.
     * @param string $start Start of the billing period
     * @param string $end End of the billing period
     */
    public function sendEmail()
    {
        // check for non_empty email-field rather than unlocked user?
        if ($this['Residents']['unlocked'] == true)
        {
            
            
            // compose the message
            $messageBody = get_partial('global/billingMail', array('firstName' => $this['Residents']['first_name'],
                                                                'start' => $this['billingperiod_start'],
                                                                'end' => $this['billingperiod_end'],
                                                                'billId' => $this['id'],
                                                                'amount' => $this['amount'],
                                                                'accountNumber' => $this['Residents']['account_number'],
                                                                'bankNumber' => $this['Residents']['bank_number'],
                                                                'itemizedBill' => $this->getItemizedBill()));
            $message = Swift_Message::newInstance()
                ->setFrom(sfConfig::get('hekphoneFromEmailAdress'))
                ->setTo($this['Residents']['email'])
                ->setSubject('[HEKphone] Deine Rechnung vom '.$this['date'])
                ->setBody($messageBody);
            sfContext::getInstance()->getMailer()->send($message);
            
            
        }
    }
}
