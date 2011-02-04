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

    /* create form an fill it with the users current settings */
    $this->form = new SettingsForm();
    $this->form->setDefault('newEmail', $resident->get('email'));
    $this->form->setDefault('reducedCdrs', $resident->get('shortened_itemized_bill'));
    $this->form->setDefault('vm_active', $resident->get('vm_active'));
    $this->form->setDefault('vm_seconds', $resident->get('vm_seconds'));
    $this->form->setDefault('vm_sendEmailOnNewMessage', $resident->get('mail_on_missed_call'));
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
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {
        // Change password if the newPassword field is not empty
        if ($form->getValue('newPassword') != '')
        {
          // if the new passwort and the repetition matches got checked via validator of the form
          $this->resident->setPassword($request['settings']['newPassword']);
        }

        // change the email address only if the user submitted one
        if ($form->getValue('newEmail') != '')
        {
          $this->resident->setEmail($request['settings']['newEmail']);
        }

        // change pin if not empty
//        if ($request['settings']['newPin'] != '')
//        {
//          $resident->setPin($request['settings']['newPin']);
//        }

        // Replace last three digits of the call details destination with xxx?
        $this->resident->set('shortened_itemized_bill', $form->getValue('reducedCdrs'));

        // Set a users lanuage
        // $resident->setCulture($request['settings']['language']);

        $this->resident->setVoicemailSettings($this->form->getValue('vm_active'),
                                          $this->form->getValue('vm_seconds'),
                                          $this->form->getValue('vm_sendEmailOnNewMessage'),
                                          $this->form->getValue('vm_attachMessage'),
                                          $this->form->getValue('vm_sendEmailOnMissedCall'));

        $this->resident->save();

        $this->getUser()->setFlash('notice', 'resident.settings.successfull');
        $this->redirect('settings/index?residentid=' . $this->resident->getId());
      }
    }
  }
}
