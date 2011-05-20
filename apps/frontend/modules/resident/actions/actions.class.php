<?php

/**
 * resident actions.
 *
 * @package    hekphone
 * @subpackage resident
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class residentActions extends sfActions
{
  /**
   * Displays a list of all current residents which can be sorted by
   * room number, last name or move in date via the :orderedby parameter
   * of the request.
   *
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $response = $this->getResponse();

    switch ($request->getParameter('orderby'))
    {
      case 'room':
       $this->residents = Doctrine_Core::getTable('Residents')
          ->findCurrentResidents('rooms.room_no');
        $response->addStyleSheet('ResidentsListByRoomNo');
        break;
      case 'name':
        $this->residents = Doctrine_Core::getTable('Residents')
          ->findCurrentResidents('last_name');
        $response->addStyleSheet('ResidentsListByLastName');
        break;
      case 'move_in':
        $this->residents = Doctrine_Core::getTable('Residents')
          ->findCurrentResidents('move_in');
        $response->addStyleSheet('ResidentsListByMoveIn');
        break;
      default:
        $this->residents = Doctrine_Core::getTable('Residents')
          ->findCurrentResidents();
        $response->addStyleSheet('ResidentsListByRoomNo');
    }
    $response->addStyleSheet('ResidentsList');
  }

  /**
   * Displays the form to edit a residents details.
   *
   * @param sfWebRequest $request
   */
  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($resident = Doctrine_Core::getTable('Residents')->find(array($request->getParameter('residentid'))), sprintf('Object residents does not exist (%s).', $request->getParameter('residentid')));
    $this->form = new ResidentsForm($resident);


    // So we can access the resident's data from the template/view layer
    $this->resident = $resident;
  }

  /**
   * Updates a residents details. The form created in the view belonging to
   * executeEdit() calls this action.
   *
   * @param sfWebRequest $request
   */
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($resident = Doctrine_Core::getTable('Residents')->find(array($request->getParameter('residentid'))), sprintf('Object residents does not exist (%s).', $request->getParameter('residentid')));
    $this->form = new ResidentsForm($resident);

    // pass the residents data to the view layer
    $this->resident = $resident;

    $this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }

  /**
   * actually apply changes, made to the resident, to the database
   * in this step, the asterisk_* tables also get updated, the neccesairy
   * vm-settings created, the extension is modified to point to the correct
   * voicemailbox and so on
   *
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $lockStateChanged = false;
      if($form->getValue('unlocked') != $this->resident->getUnlocked())
      {
        $lockStateChanged = true;
      }
      $resident = $form->save();

      if($lockStateChanged
         && $form->getValue('unlocked') == true                        // and he has been unlocked
         && ! $this->resident->get('password'))                        // and has no password, means he was never unlocked before
      {
        $password = $this->resident->resetPassword();
        $this->resident->save();
        $this->resident->Rooms->Phones->uploadConfiguration(false, false);

        sfProjectConfiguration::getActive()->loadHelpers("Partial"); //For the Email. Load this automatically. How?
        $this->resident->sendUnlockEmail(date('d.m.Y'), $password);
      }

      if( ! Doctrine_Core::getTable('AsteriskExtensions')
            ->updateResidentsExtension($this->resident))
      {
          $this->getUser()->setFlash('error', 'resident.edit.resetExtensionsFailed');
      }

      $this->getUser()->setFlash('notice', 'resident.edit.successful');
      $this->redirect('@resident_edit?residentid='.$resident->getId());
    }
  }

  public function executeLockOnFailedDebit(sfWebRequest $request) {
    sfProjectConfiguration::getActive()->loadHelpers("Partial");
    $this->forward404Unless($resident = Doctrine_Core::getTable('Residents')->find(array($request->getParameter('id'))), sprintf('Object residents does not exist (%s).', $request->getParameter('residentid')));

    $resident->set('unlocked', false);
    $resident->save();

    $this->getUser()->setFlash('notice', 'resident.lockOnFailedDebit.successful');

    $messageBody = get_partial('global/failedDebitMail',
                   array('first_name' => $resident->get('first_name')));
    $message = Swift_Message::newInstance()
        ->setFrom(sfConfig::get('hekphoneFromEmailAdress'))
        ->setTo($resident->get('email'))
        ->setSubject('[HEKphone] Telefon wegen Rücklastschrift gesperrt')
        ->setBody($messageBody);

    $this->getMailer()->send($message);


    $this->redirect('@resident_edit?residentid='.$resident->getId());
  }

  public function executeResetPassword(sfWebRequest $request) {
    sfProjectConfiguration::getActive()->loadHelpers("Partial");
    $this->forward404Unless($resident = Doctrine_Core::getTable('Residents')->find(array($request->getParameter('id'))), sprintf('Object residents does not exist (%s).', $request->getParameter('residentid')));

    $newPassword = $resident->resetPassword();

    $this->getUser()->setFlash('notice', 'resident.resetPassword.successful');

    $messageBody = get_partial('global/resetPasswordMail',
                   array('first_name' => $resident->get('first_name'),
                         'password' => $newPassword));
    $message = Swift_Message::newInstance()
        ->setFrom(sfConfig::get('hekphoneFromEmailAdress'))
        ->setTo($resident->get('email'))
        ->setSubject('[HEKphone] Passwort zurückgesetzt')
        ->setBody($messageBody);

    $this->getMailer()->send($message);

    $this->redirect('@resident_edit?residentid='.$resident->getId());
  }

  /* TODO: Implement sending of welcome email manually */
  /*
  public function executeSendWelcomeMail(sfWebRequest $request) {
    sfProjectConfiguration::getActive()->loadHelpers("Partial");
    $this->forward404Unless($resident = Doctrine_Core::getTable('Residents')->find(array($request->getParameter('id'))), sprintf('Object residents does not exist (%s).', $request->getParameter('residentid')));

    $newPassword = $resident->resetPassword();

    $this->getUser()->setFlash('notice', 'resident.sendWelcomeMail.successful');

    $messageBody = get_partial('global/welcomeMail',
                   array('first_name' => $resident->get('first_name')));
    $message = Swift_Message::newInstance()
        ->setFrom(sfConfig::get('hekphoneFromEmailAdress'))
        ->setTo($resident->get('email'))
        ->setSubject('[HEKphone] Willkommen bei HEKPhone')
        ->setBody($messageBody);

    $this->getMailer()->send($message);

    $this->redirect('@resident_edit?residentid='.$resident->getId());
  } */
}
