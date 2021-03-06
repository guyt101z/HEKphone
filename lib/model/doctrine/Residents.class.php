<?php
/**
 * Residents
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Residents extends BaseResidents
{
    private $currentBillAmount = NULL; // holds sum of the charges of the residents calls which are not assigned to any bill
                                       // (all the calls he made in the current month) in EURO

    /*
     * Gets the residents current bills amount. This function will query the database
     * if neccesary and take the value stored in $this->currentBillAmount otherwise.
     * Value is returned in Euros not in Cents!
     */
    public function getCurrentBillAmount() {
        if( is_null($this->currentBillAmount)) {
            $collCurrentBillAmount = Doctrine_Query::create()
                ->from('Calls c')
                ->select('SUM(c.charges)')
                ->where('bill IS NULL')
                ->addWhere('resident = ?', $this->id)
                ->execute();

            $this->currentBillAmount = $collCurrentBillAmount[0]['SUM']/100;
        }

        return $this->currentBillAmount;
    }

    /**
     * Gets the sum of charges (in EURO) of the unbilled calls of a resident for
     * a given time period.
     * @param date $start
     * @param date $end
     * @return number Amount in Euro
     */
    public function getBillAmountForTimePeriod($start, $end) {
        $amount = Doctrine_Query::create()
                ->from('Calls c')
                ->select('SUM(c.charges)')
                ->where('bill IS NULL')
                ->addWhere('resident = ?', $this->id)
                ->addWhere('date <= ?', $end . ' 23:59:59')
                ->addWhere('date >= ?', $start)
                ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
                ->execute();

        return $amount/100; //return value in euros
    }

    public function __toString()
    {
        return $this->get('Rooms') . " " . $this->first_name . " " . $this->last_name;
    }

     /**
     * Writes the residents password md5-encrypted to the database.
     *
     * password change.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
      // don't update to empty password
      if ($password == '')
      {
        return $this;
      }
      else
      {
        $phone = $this->Rooms->Phones;

        return $this->_set('password', md5($password));
      }
    }

    /**
     * Returns a "random" alphanumerical 7 character long password.
     * @return string
     */
    public function createPassword()
    {
    	$token = 'abcdefghjkmnpqrstuvz123456789';

        $password = '';
        for ($i = 0; $i < 7; $i++)
        {
           $password .= $token[(rand() % strlen($token))];
         }

        return $password;
    }

    /**
     * Resets a users password.
     *
     * @return string new password
     */
    public function resetPassword()
    {
        $newPassword = $this->createPassword();
        $this->set('password', $newPassword);

        return $newPassword;
    }

    /**
     * Creates a residents voicemailbox-entry if it does not exist yet
     * @return true when a new mailbox is created, false otherwise
     */
    public function createVoicemailbox() {
      if( ! isset($this->AsteriskVoicemail)) {
        $this->AsteriskVoicemail->set('mailbox', $this->get('id')); // this is the parameter, asterisk looks for when calling voicemail(xxx)
        $this->AsteriskVoicemail->set('uniqueid', $this->get('id')); // has to be set but not neccesairly equal to the mailbox id
        $this->AsteriskVoicemail->set('email', $this->get('email'));

        return true;
      } else {
        return false;
      }
    }

    /**
     * Sets a residents voicemail-settings. vm_seconds only apply after calling
     * updateExtensions() afterwards.
     *
     * @param boolean $active
     * @param integer $seconds
     * @param boolean $mailOnNewMessage
     * @param boolean $attachMessage
     * @return $this
     */
    public function setVoicemailSettings($active, $seconds, $mailOnNewMessage, $attachMessage, $saycid)
    {
      /* Create Voicemailbox, if it does not exist yet */
      $this->createVoicemailbox();

      // there's no option not to send voicemails by email (sendvoicemail is something else)
      // If the resident does not whish to receive notifications we simply delete the email-adress
      if($mailOnNewMessage)
      {
          $this->AsteriskVoicemail->set('email', $this->email);
      } else {
          $this->AsteriskVoicemail->set('email', '');
      }

      // Asterisk uses yes and no not true/false in its config files and tables
      $attachMessage = ($attachMessage) ? "yes" : "no";
      $this->AsteriskVoicemail->set('attach', $attachMessage);

      $saycid = ($saycid) ? "yes" : "no";
      $this->AsteriskVoicemail->set('saycid', $saycid);

      $this->set('vm_active', $active);
      $this->set('vm_seconds', $seconds);

      $this->save(); // FIXME: one should not need this

      return $this;
    }

    public function getVoicemailSendEmailOnNewMessage() {
      return ( ! $this->AsteriskVoicemail->get('email'))? false : true;
    }

    public function getVoicemailAttachMessage() {
      return ($this->AsteriskVoicemail->get('attach') != 'yes')? false : true;
    }

    public function getVoicemailSaycid() {
      return ($this->AsteriskVoicemail->get('saycid') != 'yes')? false : true;
    }

    /**
     * Sets the redirect parameters of the resident.
     * Afterwards, updateExtensions() has to be executed in order to generate the
     * appropriate entries in AsteriskExtensions
     *
     * @param bool $active
     * @param string $to
     * @param int $seconds
     * @return $this
     */
    public function setRedirect($active, $to, $seconds) {
      $this->_set('redirect_active', $active);
      $this->_set('redirect_seconds', $seconds);
      $this->_set('redirect_to', $to);

      $this->save(); // FIXME: one should not need this

      return $this;
    }
    /**
     * Recreates the residents extensions in AsteriskExtensions.
     * Has to be executed to apply redirect settings and voicemail-settings (vm_seconds)
     * @return bool
     */
    public function updateExtensions() {
      if( ! Doctrine_Core::getTable('AsteriskExtensions')
            ->updateResidentsExtension($this))
      {
          return false;
      }

      return true;
    }

    /**
     * Sends a lock/unlock email depending on the residents "unlocked" property
     */
    public function sendLockUnlockEmail($date, $password = null)
    {
      if($this->unlocked)
      {
        $this->sendUnlockEmail($password);
      }
      else
      {
        $this->sendLockEmail($date);
      }
    }

    /**
     * Sends an E-Mail containing information about him being unlocked and
     * about general information to a resident.
     */
    public function sendUnlockEmail($password)
    {
      $messageBody = get_partial('global/movingInMail', array('bank_number' => $this['bank_number'],
                                                              'account_number' => $this['account_number'],
                                                              'email' => $this['email'],
                                                              'password' => $password));

      $message = Swift_Message::newInstance()
                ->setFrom(sfConfig::get('hekphoneFromEmailAdress'))
                ->setTo($this['email'])
                ->setSubject('[HEKphone] Deine Telefonfreischaltung')
                ->setBody($messageBody);
      sfContext::getInstance()->getMailer()->send($message);
    }

    /**
     * Notifies a user that he's going to be locked at $lockDate.
     *
     * @param string $lockDate
     */
    public function sendLockEmail($lockDate)
    {
      $messageBody = get_partial('global/movingOutMail', array('first_name' => $this['first_name'],
                                                               'lockDate' => $lockDate));

      $message = Swift_Message::newInstance()
          ->setFrom(sfConfig::get('hekphoneFromEmailAdress'))
          ->setTo($this['email'])
          ->setSubject('[HEKphone] Dein Auszug')
          ->setBody($messageBody);
      sfContext::getInstance()->getMailer()->send($message);
    }

    /**
     * Checks and acts upon almost (or completely) reached bill limit.
     * Sends warning Email for both thresholds (see sfConfig variables)
     * and locks the user if he exceeds his limit.
     *
     */
    public function checkIfBillLimitIsAlmostReached()
    {
    	$percentage = $this->getCurrentBillAmount()/$this->bill_limit;

    	if ($percentage > 1)
    	{
            $this->setUnlocked(false);
            $this->sendLimitReachedEmail();
    	}
    	elseif( $percentage >= sfConfig::get('billLimitSecondThreshold'))
    	{
            $this->set('warning2',true);
    	    $this->sendLimitWarningEmail(sfConfig::get('billLimitSecondThreshold'));
    	}
    	elseif ($percentage >= sfConfig::get('billLimitFirstThreshold'))
    	{
    	    $this->sendLimitWarningEmail(sfConfig::get('billLimitFirstThreshold'));
    	    $this->set('warning1',true);
        }
    }

    /**
     * Notifies a resident that he almost reached his bill_limit.
     * $billLimitThreshold represents the percentage of the limit he has reached
     * $currentBillAmount holds the residents sum of all the Residents unbilled calls
     * @param unknown_type $billLimitThreshold
     * @param unknown_type $currentBillAmount
     */
    public function sendLimitWarningEmail($billLimitThreshold)
    {
    	$messageBody = get_partial('global/currentBillAmountReachedThresholdMail',
    	               array('first_name' => $this['first_name'],
    	                     'threshold' => $billLimitThreshold,
    	                     'limit' => $this['bill_limit'],
    	                     'currentBillAmount' => $this->getCurrentBillAmount()));

        $message = Swift_Message::newInstance()
            ->setFrom(sfConfig::get('hekphoneFromEmailAdress'))
            ->setTo($this['email'])
            ->setSubject('[HEKphone] Gebührenwarnung!')
            ->setBody($messageBody);

        sfContext::getInstance()->getMailer()->send($message);
    }

    /**
     * Notifies a resident that he reached his limit and is now locked and can't
     * do any more calls
     */
    public function sendLimitReachedEmail()
    {
        $messageBody = get_partial('global/currentBillAmountReachedLimitMail',
                       array('first_name' => $this['first_name'],
                             'limit' => $this['bill_limit'],
                             'currentBillAmount' => $this->getCurrentBillAmount()));

        $message = Swift_Message::newInstance()
            ->setFrom(sfConfig::get('hekphoneFromEmailAdress'))
            ->setTo($this['email'])
            ->setSubject('[HEKphone] Gebührenlimit überschritten!')
            ->setBody($messageBody);

        sfContext::getInstance()->getMailer()->send($message);
    }

    /**
     * Checks wheter the resident still lives here.
     *
     * @return bool
     */
    public function isStillLivingHere() {
        if($this->get('move_in') <= date('Y-m-d')
          && ($this->get('move_out') >= date('Y-m-d') || is_null($this->get('move_out')))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets alls unbilled calls belonging to the Resident ordered by date desc
     * @return Doctrine_Collection
     */
    public function getUnbilledCalls() {
        $unbilledCalls = Doctrine_Query::create()
                            ->from('Calls')
                            ->addWhere('bill is null')
                            ->addWhere('resident = ?', $this->get('id'))
                            ->orderBy('date desc')
                            ->execute();
        return $unbilledCalls;
    }

    /**
     * Creates an Bill object for all unbilled Calls of the resident, saves this
     * Object to the database, and relates the accoring calls to the bill.
     * (So they are not "unbilled" anymore.)
     *
     * @return bool|Bills
     */
    public function createBillFromUnbilledCalls() {
        $unbilledCalls = $this->getUnbilledCalls(); //sorted by date desc

        if( count($unbilledCalls) == 0) {
            return false;
        }

        $bill = new Bills();
        $bill->set('resident', $this->get('id'))
             ->set('amount', round($this->getCurrentBillAmount(), 2))
             ->set('date', date("Y-m-d"))
             ->set('billingperiod_end', $unbilledCalls[0]->get('date'))
             ->set('billingperiod_start', $unbilledCalls[count($unbilledCalls)-1]->get('date'))
             ->set('manually_created', true);
        $bill->save();

        for($i=0; $i<count($unbilledCalls); $i++) {
            $unbilledCalls[$i]->set('bill', $bill->get('id')); // mark call as billed
        }
        $unbilledCalls->save();

        return $bill;
    }
}
