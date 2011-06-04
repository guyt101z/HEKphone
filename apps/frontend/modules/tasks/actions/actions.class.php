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
    /* to highlight the current step the user has to execute $step is used*/
    if($request->hasParameter('step')) {
      $this->step = $request->getParameter('step');
    } else {
      $this->step = 1;
    }

    $this->dateForm = new NewBillsForm();

    /* the (simulated) bills are stored in the users session */
    if($this->getUser()->hasAttribute('bills')) {
      $this->bills = $this->getUser()->getAttribute('bills')->toArray();
      $this->totalAmount = $this->getUser()->getAttribute('bills')->getTotalAmount();
    } else {
      $this->bills = false;
    }
  }

  public function executeSimulateNewBills(sfWebRequest $request) {
    $this->dateForm = new NewBillsForm();
    $this->dateForm->bind($request->getParameter($this->dateForm->getName()));
    if ($this->dateForm->isValid())
    {
      $start = $this->dateForm->getValue('billingperiod_start');
      $end   = $this->dateForm->getValue('billingperiod_end');
      if( ! $billsCollection = Doctrine_Core::getTable('Bills')->getBillsCollectionForUnbilledCalls($start, $end)) {
        $this->getUser()->setAttribute('bills', null);
        $this->getUser()->setFlash('notice', 'task.bills.new.simulate.no_bills');
      } else {
        $this->getUser()->setAttribute('bills', $billsCollection);
      }
    }

    $this->redirect('task_newBills', array('step' => 2));
  }

  public function executeCreateNewBills(sfWebRequest $request) {
    /* there have to be bills in the session to create (a test simulation has to be run first) */
    if( ! $this->getUser()->hasAttribute('bills')) {
        $this->getUser()->setFlash('error', 'task.bills.create.simulate_first');
        $this->redirect('task_newBills', array('step' => 1));
    }

    $bills = $this->getUser()->getAttribute('bills');

    /* check if the bills are already saved to the database (the user clicked submit twice) */
    if( $bills->exists()) {
        $this->getUser()->setFlash('error', 'task.bills.create.not_again');
        $this->redirect('task_newBills', array('step' => 3));
    }

    /* check wheter there are errors before we get stuck in the middle of the billing process */
    if(is_array($errors = $bills->hasErrors())) {
      $this->getUser()->setFlash('error', 'Die folgenden Fehler würden auftreten, deshalb wurden keine Rechnungen erstellt:' . print_r($errors, true));
      $this->redirect('task_newBills', array('step' => 2));
    }

    /* create the bills for real: save the bills, link the calls and send emails */
    $bills->save();  //save the bills to the database and obtain billids
    $bills->linkCallsToBills(); //relate the calls to the bills (mark them as billed)
    sfProjectConfiguration::getActive()->loadHelpers("Partial"); //FIXME: needed for the email template. Load this automatically
    $bills->sendEmails();

    /* notify the user */
    $bills = $this->getUser()->setAttribute('bills', $bills);
    $this->getUser()->setFlash('notice', 'task.bills.new.create.successful');
    $this->redirect('task_newBills', array('step' => 3));
  }


  public function executeContinueWithOldBills(sfWebRequest $request) {
    /* to highlight the current step the user has to execute $step is used*/
    if($request->hasParameter('step')) {
      $this->step = $request->getParameter('step');
    } else {
      $this->step = 1;
    }

    $this->dateForm = new ContinueBillsForm();

    Doctrine_Core::getTable('Bills')->setAttribute(Doctrine::ATTR_COLLECTION_CLASS, 'BillsCollection');

    /* Get the bills where a debit has to be performed */
    if( ! $this->getUser()->hasAttribute('bills')) {
      $billsCollection = Doctrine_Core::getTable('Bills')->findBillsWithoutDebit();
      $this->getUser()->setAttribute('bills', $billsCollection);
    } else {
      $billsCollection = $this->getUser()->getAttribute('bills');
    }

    if( ! $billsCollection) {
        $this->getUser()->setFlash('error', 'task.bills.continute.no_old_bills_without_debit');
    }

    $this->bills = $billsCollection->toArray();
    $this->totalAmount = $billsCollection->getTotalAmount();
  }

  public function executeGetDtaus(sfWebRequest $request) {
    if( ! $this->getUser()->hasAttribute('bills')) {
      $this->getUser()->setFlash('error', 'task.bills.continue.no_bills_selected');
      $this->redirect('task_continueWithOldBills', array('step' => 1));
    }

    $bills = $this->getUser()->getAttribute('bills');

    /* check wheter there are errors beforehand */
    if(is_array($errors = $bills->hasDtausErrors())) {
      $this->getUser()->setFlash('error', 'Die folgenden Fehler würden auftreten, deshalb wurden keine Dtaus-Datei erstellt:' . print_r($errors, true));
      $this->redirect('task_continueWithOldBills', array('step' => 1));
    }

    /* get the dtaus-files contents and pass it right through */
    if($dtausContents = $bills->getDtausContents()) {
      echo $dtausContents;
      sfConfig::set('sf_web_debug', false);
      return sfView::NONE;
    } else {
      $this->getUser()->setFlash('error', 'task.bills.continue.dtaus_creation_failed');
    }
  }

  public function executeMarkAsDone(sfWebRequest $request) {
    if( ! $this->getUser()->hasAttribute('bills')) {
      $this->getUser()->setFlash('error', 'task.bills.continue.no_bills_selected');
      $this->redirect('task_continueWithOldBills', array('step' => 1));
    }

    $this->getUser()->getAttribute('bills')->markAsDebited();
    $this->getUser()->getAttribute('bills')->save();
    $this->getUser()->setAttribute('bills', null);

    $this->getUser()->setFlash('notice', 'task.bills.continue.markAsDone.successful');
    $this->redirect('task_continueWithOldBills', array('step' => 2));
  }
}
