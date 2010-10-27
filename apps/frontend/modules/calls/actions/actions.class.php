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
  * user, but only if the users id equals the $request[residentid] or if the user is part of the
  * hekphone-staff (credential: hekphone)
  *
  * If the Action is called via the route @bills_detail (<-calls/:billid), the parameter billid
  * is set and the action additionally shows the details of the bill with the matching id, but only
  * if the user id requests the residentid associated with the bill.
  *
  * If the action is called via the route @calls(<-calls/index), residentid and billid are not set and
  * the calls of the logged in user is shown.
  *
  * XXX: Is this secure? First thought: yes. but check again for weired combinations of billid and residentid
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    // Secure the action: Users can only access their own calls/bills except they're
    // hekphone member (see function comment)
    if ( $this->hasRequestParameter('residentid') &&
         ! ( $request['residentid'] == $this->getUser()->getAttribute('id')
             || $this->getUser()->hasCredential('hekphone')))
    {
      $this->forward('default', 'secure');
    }

    // If the action is called via /resident/:residentid/calls display the
    // calls/bills of the resident with the matching residentid
    if ($this->hasRequestParameter('residentid'))
    {
      $this->residentid = $request['residentid'];
    }
    else
    {
      $this->residentid = $this->getUser()->getAttribute('id');
    }

    // get the calls/bills and pass them to the view layer
    $this->callsCollection = Doctrine_Query::create()
                            ->from('Calls c')
                            ->addWhere('c.bill = 0')
                            ->addWhere('c.resident = ?', $this->residentid)
                            ->execute();
    $this->billsCollection = Doctrine_Query::create()
                            ->from('Bills b')
                            ->addWhere('b.resident = ?', $this->residentid)
                            ->orderBy('b.date')
                            ->limit(12)
                            ->execute();
  }
}
