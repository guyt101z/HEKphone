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
   * Displays an overview over various available tasks.
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward404();
  }

  /**
   * Displays the page to simulate/create new bills for a time period.
   * @param sfWebRequest $request
   */
  public function executeNewBills(sfWebRequest $request) {
    /* to highlight the current step the user has to execute $step is used*/
    if($request->hasParameter('step')) {
      $this->step = $request->getParameter('step');
    } else {
      $this->step = 1;
    }

    $this->dateForm = new NewBillsForm();

    /* the (simulated) bills are stored in the users session */
    if($this->getUser()->hasAttribute('bills') && count($this->getUser()->getAttribute('bills')) > 0) {
      $bills = $this->getUser()->getAttribute('bills');
      $this->bills = $bills->toArray();
      $this->totalAmount = $bills->getTotalAmount();
    } else {
      $this->bills = false;
    }
  }

  /**
   * Performs an "bill creation simulation" where an object of type BillsCollection
   * is created that holds all the bills that will be created when executing
   * executeCreateNewBills().
   * This object is stored in the user's session as attribute 'bills' and can
   * then be modified or turned into persistent bills.
   *
   * No emails are sent, no bills are saved to the database, no calls are marked as billed here.
   * @param sfWebRequest $request
   */
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
        $this->redirect('task_newBills', array('step' => 1));
      } else {
        $this->getUser()->setAttribute('bills', $billsCollection);
      }
    } else {
      //FIXME: there's no validation error message in the form because of the redirect
      $this->redirect('task_newBills', array('step' => 1));
    }

    $this->redirect('task_newBills', array('step' => 2));
  }

  /**
   * Takes the BillsCollection object stored in the 'bills' attribute of the users
   * session, saves these bills to the database, links the calls to the bills (marks
   * them as billed) and notifies the residents via email about their bills.
   *
   * @param sfWebRequest $request
   */
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

  /**
   * Checks for bills in the database for which no debit has yet been created
   * and displays these to the user who can now download the dtaus file that is
   * sent to the bank to do the debit.
   *
   * @param sfWebRequest $request
   */
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
    if( ! $billsCollection = $this->getUser()->getAttribute('oldBills')) {
        $billsCollection = Doctrine_Core::getTable('Bills')->findBillsWithoutDebit();
        $this->getUser()->setAttribute('oldBills', $billsCollection);
    }

    if( ! $billsCollection || count($billsCollection) == 0) {
        $this->getUser()->setAttribute('oldBills', null);
        $this->getUser()->setFlash('notice', 'task.bills.continue.no_old_bills_without_debit');
        return sfView::SUCCESS;
    }

    $this->bills = $billsCollection->toArray();
    $this->totalAmount = $billsCollection->getTotalAmount();
  }

  /**
   * Returns the dtaus file for the bills stored as the users session attribute
   * 'bills'. The created file is also saved on the server as data/billing/{date}.txt
   * On error, the user is redirected back to continueWithOldBills.
   *
   * @param sfWebRequest $request
   */
  public function executeGetDtaus(sfWebRequest $request) {
    if( ! $this->getUser()->hasAttribute('oldBills')) {
      $this->getUser()->setFlash('error', 'task.bills.continue.no_bills_selected');
      $this->redirect('task_continueWithOldBills', array('step' => 1));
    }

    $bills = $this->getUser()->getAttribute('oldBills');

    /* check wheter there are errors beforehand */
    if(is_array($errors = $bills->hasDtausErrors())) {
      $this->getUser()->setFlash('error', 'Die folgenden Fehler würden auftreten, deshalb wurden keine Dtaus-Datei erstellt:' . print_r($errors, true));
      $this->redirect('task_continueWithOldBills', array('step' => 1));
    }

    /* get the dtaus-files contents and pass it right through */
    if($dtausContents = $bills->getDtausContents()) {
      $filename = date('Y-m-d') . '_bills.txt';

      @$bills->writeDtausFile();

      $response = $this->getResponse();
      $response->setContentType('text/plain');
      $response->setHttpHeader('Content-Disposition', 'attachment; filename='.$filename);
      $response->setContent($dtausContents);

      sfConfig::set('sf_web_debug', false);

      return sfView::NONE;
    } else {
      $this->getUser()->setFlash('error', 'task.bills.continue.dtaus_creation_failed');
      $this->redirect('task_continueWithOldBills', array('step' => 1));
    }
  }

  /**
   * Refetches the old bills in the users session. Only fetches from a specified
   * date and one can also select already debited bills.
   * Then redirects back to tasks/ContinueWithOldBills.
   *
   * @param sfWebRequest $request
   */
  public function executeChooseDate(sfWebRequest $request) {
    $this->dateForm = new ContinueBillsForm();
    $this->dateForm->bind($request->getParameter($this->dateForm->getName()));
    if ($this->dateForm->isValid())
    {
      $date = $this->dateForm->getValue('date');
      $includeAlreadyDebited = $this->dateForm->getValue('include_already_debited');

      Doctrine_Core::getTable('Bills')->setAttribute(Doctrine::ATTR_COLLECTION_CLASS, 'BillsCollection');
      $bills = Doctrine_Query::create()
          ->from('Bills')
          ->addWhere('debit_sent = ?', $includeAlreadyDebited)
          ->addWhere('date = ?', $date)
          ->execute();
      $this->getUser()->setAttribute('oldBills', $bills);
    }

    $this->redirect('task_continueWithOldBills', array('step' => 1));
  }

  /**
   * This action is supposed to be executed after a debit has been sent.
   * It marks the bills as "done" (debit_send = true in the database) so they
   * won't show up again when the user tries to download the (next) dtaus file.
   *
   * @param sfWebRequest $request
   */
  public function executeMarkAsDone(sfWebRequest $request) {
    if( ! $this->getUser()->hasAttribute('oldBills')) {
      $this->getUser()->setFlash('error', 'task.bills.continue.no_bills_selected');
      $this->redirect('task_continueWithOldBills', array('step' => 1));
    }

    $this->getUser()->getAttribute('oldBills')->markAsDebited();
    $this->getUser()->getAttribute('oldBills')->save();
    $this->getUser()->setAttribute('oldBills', null);

    $this->getUser()->setFlash('notice', 'task.bills.continue.markAsDone.successful');
    $this->redirect('task_continueWithOldBills', array('step' => 2));
  }

  /**
   * Removes a bill belonging to one resident from the BillsCollection so
   * it does not get billed/there is no dtaus entry for it.
   */
  public function executeRemoveFromCollection(sfWebRequest $request) {
    // requests from the "newBills" action come with a residentid as parameter
    // requests from the "continueWithOldBills" action come with a billid
    // remove the appropriate bills from the collection
    if($billid = $request->getParameter('billid')) {
      $this->forward404Unless($bills = $this->getUser()->getAttribute('oldBills'));
      $this->forward404Unless($bills->removeBill('id', $billid));
      $this->redirect('task_continueWithOldBills', array('step' => 2));
    } elseif($residentid = $request->getParameter('residentid')) {
      $this->forward404Unless($bills = $this->getUser()->getAttribute('bills'));
      $this->forward404Unless($bills->removeBill('resident', $residentid));
      $this->redirect('task_newBills', array('step' => 2));
    } else {
      $this->forward404();
    }
  }

  public function executeUpdateBankInformation() {
    Doctrine_Core::getTable('Banks')->updateData();

    $this->getUser()->setFlash('notice', 'task.banks.update.successful');
    $this->redirect('tasks');
  }
}
