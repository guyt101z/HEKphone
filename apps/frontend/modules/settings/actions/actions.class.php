<?php

/**
 * settings actions.
 *
 * @package    hekphone
 * @subpackage settings
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class settingsActions extends sfActions
{
 /**
  * Edit the settings of a resident.
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    // If the action is accessed via /resident/xxx/settings :residentid is set
    // and should be used. If the action is called via /settings/index the users
    // id should be used.
    if ($this->hasRequestParameter('residentid'))
    {
      $this->residentid = $request['residentid'];
    }
    else
    {
      $this->residentid = $this->getUser()->getAttribute('id');
    }

    $this->forward404Unless($resident = Doctrine_Core::getTable('Residents')->findOneBy('id', $this->residentid));

    /* Create form an fill it with the users current settings */
    $this->form = new SettingsForm();
    $this->form->setDefault('newEmail', $resident->get('email'));
    $this->form->setDefault('reducedCdrs', $resident->get('shortened_itemized_bill'));
    $this->form->setDefault('sendEmailOnMissedCall', $resident->get('mail_on_missed_call'));
    $this->form->setDefault('vm_active', $resident->get('vm_active'));
    $this->form->setDefault('vm_seconds', $resident->get('vm_seconds'));
    $this->form->setDefault('vm_attachMessage', $resident->getVoicemailAttachMessage());
    $this->form->setDefault('vm_sendEmailOnNewMessage', $resident->getVoicemailSendEmailOnNewMessage());
    $this->form->setDefault('vm_saycid', $resident->getVoicemailSaycid());
    $this->form->setDefault('redirect_active', $resident->get('redirect_active'));
    $this->form->setDefault('redirect_seconds', $resident->get('redirect_seconds'));
    $this->form->setDefault('redirect_to', $resident->get('redirect_to'));
  }

  public function executeUpdate(sfWebRequest $request)
  {
    if ($this->hasRequestParameter('residentid'))
    {
      $this->residentid = $request['residentid'];
    }
    else
    {
      $this->residentid = $this->getUser()->getAttribute('id');
    }

    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($this->resident = Doctrine_Core::getTable('Residents')->findOneBy('id', $this->residentid));

    $this->form = new SettingsForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid())
    {
      // change the email address only if the user submitted one
      if ($form->getValue('newEmail') != '')
      {
        $this->resident->setEmail($request['settings']['newEmail']);
      }

      $this->resident->set('shortened_itemized_bill', $form->getValue('reducedCdrs'));
      $this->resident->set('mail_on_missed_call', $form->getValue('sendEmailOnMissedCall'));

      $this->resident->setVoicemailSettings($form->getValue('vm_active'),
                                        $form->getValue('vm_seconds'),
                                        $form->getValue('vm_sendEmailOnNewMessage'),
                                        $form->getValue('vm_attachMessage'),
                                        $form->getValue('vm_saycid'));

      $this->resident->setRedirect($form->getValue('redirect_active'),
                                   $form->getValue('redirect_to'),
                                   $form->getValue('redirect_seconds'));

      $this->resident->updateExtensions();

      // Change password if the newPassword field is not empty
      if ($form->getValue('newPassword') != '')
      {
        // save the old password hash because we need it to update the phones
        // configuration later. FIXME: This is how it should be. instead we're
        // using a standard password. this could (due to http) be easily intercepted
        $oldPasswordHash = $this->resident->getPassword();

        // if the new passwort and the repetition matches got checked via validator
        // of the form so we just need to save it here
        $this->resident->setPassword($form->getValue('newPassword'));
      }
      $this->resident->save();

      // If password has been changed, update the telephone with the new password
      if($form->getValue('newPassword') != '')
      {
        //actively load helper for the template of the configuration
        sfProjectConfiguration::getActive()->loadHelpers("Partial");
        $this->resident->Rooms->Phones->uploadConfiguration(false, false); //FIXME: catch errors
        $this->resident->Rooms->Phones->pruneAsteriskPeer(); //FIXME: catch errors
      }

      $this->getUser()->setFlash('notice', 'resident.settings.successful');
      $this->redirect('settings/index?residentid=' . $this->resident->getId());
    }
  }
}
