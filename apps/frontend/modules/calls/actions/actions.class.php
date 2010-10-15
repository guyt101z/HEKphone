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
  public function executeIndex()
  {
    $this->callsCollection = Doctrine_Query::create()
                            ->from('Calls c')
                            ->addWhere('c.bill = 0')
                            ->addWhere('c.resident = ?', $this->getUser()->getAttribute('id'))
                            ->execute();
    $this->billsCollection = Doctrine_Query::create()
                            ->from('Bills b')
                            ->addWhere('b.resident = ?', $this->getUser()->getAttribute('id'))
                            ->orderBy('b.date')
                            ->limit(12)
                            ->execute();
  }
}
