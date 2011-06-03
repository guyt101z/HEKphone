<?php

/**
 * tasks actions.
 *
 * @package    hekphone
 * @subpackage tasks
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tasksActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward404();
  }

  public function executeNewBills(sfWebRequest $request) {
    if($request->hasParameter('step')) {
      $this->step = $request->getParameter('step');
    } else {
      $this->step = 1;
    }

    $this->dateForm = new NewBillsForm();

    if($this->getUser()->hasAttribute('bills')) {
      $this->bills = $this->getUser()->getAttribute('bills')->toArray();
      $this->totalAmount = $this->getUser()->getAttribute('bills')->getTotalAmount();
    } else {
      $this->bills = false;
    }
  }

  public function executeSimulateNewBills(sfWebRequest $request) {
    $this->getUser()->setAttribute('bills', null);

    $this->dateForm = new NewBillsForm();
    $this->dateForm->bind($request->getParameter($this->dateForm->getName()));
    if ($this->dateForm->isValid())
    {
      $start = $this->dateForm->getValue('billingperiod_start');
      $end   = $this->dateForm->getValue('billingperiod_end');
      if( ! $billsCollection = Doctrine_Core::getTable('Bills')->getBillsCollectionForUnbilledCalls($start, $end)) {
        $this->getUser()->setFlash('notice', 'task.bills.new.simulate.no_bills');
      } else {
        $this->getUser()->setAttribute('bills', $billsCollection);
      }
    }

    //$this->getUser()->getAttributeHolder()->remove('test');
    $this->redirect('task_newBills', array('step' => 2));
  }

  public function executeCreateNewBills(sfWebRequest $request) {
    $this->dateForm = new NewBillsForm();

    if( ! $this->getUser()->hasAttribute('bills')) {
        $this->getUser()->setFlash('error', 'task.bills.create.simulate_first');
        $this->redirect('task_newBills', array('step' => 1));
    }

    $bills = $this->getUser()->getAttribute('bills');

    $bills->save();  //save the bills to the database and obtain billids

    try{
      $bills->linkCallsToBills(); //relate the calls to the bills (mark them as billed)
    } catch(Exception $e) {
      $this->getUser()->setFlash('error', 'Die Rechnungen wurden gespeichert, aber die Gespräche nicht (vollständig) den Rechnungen zu geordnet! Die Fehlermeldung war: '. $e->getMessage());
      $error = true;
    }

    sfProjectConfiguration::getActive()->loadHelpers("Partial"); //FIXME: For the Email. Load this automatically
    $bills->sendEmails();

    $bills = $this->getUser()->setAttribute('bills', $bills);

    if( ! $error) {
      $this->getUser()->setFlash('notice', 'task.bills.new.create.successful');
    }


    $this->redirect('task_newBills', array('step' => 3));
  }


  public function executeContinueWithOldBills(sfWebRequest $request) {
    $this->step = 1;

    if( ! $billsCollection = Doctrine_Core::getTable('Bills')->findBillsWithoutDebit()) {
        $this->getUser()->setFlash('error', 'task.bills.continute.no_old_bills_without_debit');
    }
  }
}
