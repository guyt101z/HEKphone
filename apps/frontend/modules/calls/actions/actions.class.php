<?php

/**
 * calls actions.
 *
 * @package    hekphone
 * @subpackage calls
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class callsActions extends sfActions
{
 /**
  * Lists a users unbilled calls/bills.
  *
  * If the action is called via the route @resident_calls (<-resident/:residentid/calls)
  * the parameter residentid is set. The action now shows the calls/bills of the corresponding
  * user, but only if the users id equals the $request[residentid] and therefore has the
  * credential "owner" which is determinded in the filter cahin, or if the user is part of the
  * hekphone-staff (credential: hekphone)
  *
  * If the Action is called via the route @bills_detail (<-calls/:billid), the parameter billid
  * is set and the action additionally shows the details of the bill with the matching id, but only
  * if the user id requests the residentid associated with the bill.
  *
  * If the action is called via the route @calls(<-calls/index), residentid and billid are not set and
  * the calls of the logged in user is shown.
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    // If the action is called via /resident/:residentid/calls display the
    // calls/bills of the resident with the matching residentid
    // TODO: move this to a filter
    if ($this->hasRequestParameter('residentid'))
    {
      $this->residentid = $request['residentid'];
      $this->forward404Unless(Doctrine_Core::getTable('Residents')->createQuery()->where('id = ?', $this->residentid)->count() == 1);
    }
    else
    {
      $this->residentid = $this->getUser()->getAttribute('id');
    }

    // get the calls/bills and pass them to the view layer
    $this->callsCollection = Doctrine_Query::create()
                            ->from('Calls c')
                            ->addWhere('c.bill IS NULL')
                            ->addWhere('c.resident = ?', $this->residentid)
                            ->orderBy('date desc')
                            ->execute();
    $this->callsCollection->loadRelated('Rates'); // we're displaying the rates name of every call in the view layer
                                                  // and want don't want to create one query each but one big one
    $this->billsCollection = Doctrine_Query::create()
                            ->from('Bills b')
                            ->addWhere('b.resident = ?', $this->residentid)
                            ->orderBy('b.date')
                            ->limit(12)
                            ->execute();
  }

  public function executeSendBillEmail(sfWebRequest $request)
  {
    // If the action is called via /resident/:residentid/calls display the
    // calls/bills of the resident with the matching residentid
    // TODO: move this to a filter
    if ($this->hasRequestParameter('residentid'))
    {
      $this->residentid = $request['residentid'];
      $this->forward404Unless(Doctrine_Core::getTable('Residents')->createQuery()->where('id = ?', $this->residentid)->count() == 1);
    }
    else
    {
      $this->residentid = $this->getUser()->getAttribute('id');
    }

    sfProjectConfiguration::getActive()->loadHelpers("Partial"); //FIXME: For the Email. Load this automatically

    $bill = Doctrine_Core::getTable('Bills')->findOneById($request->getParameter('billid'));
    $bill->sendEmail();

    $this->getUser()->setFlash('notice', 'calls.billEmailSent');

    $this->redirect('@calls?residentid=' . $this->residentid);

  }

  public function executeGetCharges(sfWebRequest $request)
  {
    $this->forwardUnless($destination = $request->getParameter('destination'), 'calls', 'index');

    //Prepare CDR as if the user has called the number
    $cdr = new AsteriskCdr();
    $cdr->calldate  = date('Y-m-d H:m:s');
    $cdr->src       = '8695' . $this->getUser()->getAttribute('roomNo');
    $cdr->dst       = $destination;
    $unlockedContexts = sfConfig::get('asteriskUnlockedPhonesContexts');
    $cdr->dcontext  = $unlockedContexts[0];
    $cdr->channel   = 'SIP';

    if(substr($destination,0,1) == '0') {
        $cdr->userfield = 'Versatel';
    } elseif(substr($destination,0,2) == '60') {
        $cdr->userfield = 'pbxnetwork';
    } elseif(substr($destination,0,1) == '*') {
        $cdr->userfield = 'free';
    } elseif(substr($destination,0,1) == '1') {
        $cdr->userfield = 'free';
    } elseif(substr($destination,0,1) == '3') {
        $cdr->userfield = 'free';
    } elseif(substr($destination,0,1) == '5') {
        $cdr->userfield = 'free';
    } elseif(substr($destination,0,1) == '7') {
        $cdr->userfield = 'free';
    }



    // get the Rate of the call catch every exception
    try {
      $rate = $cdr->getRate();
    } catch (Exception $e)
    {
      $rate = false;
    }

    if ($request->isXmlHttpRequest())
    {
      if ( ! $rate)
      {
        return sfContext::getInstance()->getI18n()->__('calls.charges.no_result');
      }

      return $this->renderText(round($rate->getCharge(60),2) . 'ct/min');
    }

    // For non-JS-users
    if($rate) {
      $chargeString = '&charges=' . round($rate->getCharge(60),2) . 'ct/min';
    } else {
      $chargeString = '&charges=' . sfContext::getInstance()->getI18n()->__('   calls.charges.no_result');
    }
    $this->redirect('calls/index?destination=' . $destination . $chargeString);
  }
}
