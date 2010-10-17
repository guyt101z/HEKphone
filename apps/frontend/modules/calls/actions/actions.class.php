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
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //if some resident tries to access calls of other users via resident/:residentid/calls
    if ( isset($request['residentid']) &&
         ! ($request['residentid'] == $this->getUser()->getAttribute('id') || $this->getUser()->hasCredential('hekphone')))
    {
      $this->forward('default', 'secure');
    }

    if (isset($request['residentid']))
    {
      $residentid = $request['residentid'];
    }
    else
    {
      $residentid = $this->getUser()->getAttribute('id');
    }

    $this->callsCollection = Doctrine_Query::create()
                            ->from('Calls c')
                            ->addWhere('c.bill = 0')
                            ->addWhere('c.resident = ?', $residentid)
                            ->execute();
    $this->billsCollection = Doctrine_Query::create()
                            ->from('Bills b')
                            ->addWhere('b.resident = ?', $residentid)
                            ->orderBy('b.date')
                            ->limit(12)
                            ->execute();
  }
}
