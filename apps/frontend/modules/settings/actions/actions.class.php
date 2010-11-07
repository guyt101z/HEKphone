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
    // Redirect user that try to edit anothers settings without having the
    // right credentials ('hekphone') (see also callsIndex action.)
    if ( $this->hasRequestParameter('residentid') &&
         ! ( $request['residentid'] == $this->getUser()->getAttribute('id')
             || $this->getUser()->hasCredential('hekphone')))
    {
      $this->forward('default', 'secure');
    }

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

    // Create the form
    $this->form = new SettingsForm();

    if($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {
        $resident = Doctrine_Core::getTable('Residents')->findOneBy('id', $this->residentid);

        // Change password if the newPassword field is not empty
        if ($request['settings']['newPassword'] != '')
        {
          // compare the old residents password to the one, the user entered
          if ($request['settings']['oldPassword'] != '' && ( md5($request['settings']['oldPassword']) == $resident->password))
          {
            //set new password
            $resident->setPassword($request['settings']['newPassword']);
          }
          else
          {
            // notify the user about the wrong password
            $this->getUser()->setFlash('error', 'resident.edit.error.oldPasswordMismatch');
            //stop execution and display the form
            return sfView::SUCCESS;
          }
        }

        // change the email address if the user submitted one
        if ($request['settings']['newEmail'] != '')
        {
          $resident->setEmail($request['settings']['newEmail']);
        }

        // change pin if not empty
//        if ($request['settings']['newPin'] != '')
//        {
//          $resident->setPin($request['settings']['newPin']);
//        }

        // Replace last three digits of the call details destination with xxx?
        $resident->set('shortened_itemized_bill', $request['settings']['reducedCdrs']);

        // Set a users lanuage
        // $resident->setCulture($request['settings']['language']);

        $resident->setVoicemailSettings($request['settings']['vm_active'],
                                        $request['settings']['vm_seconds'],
                                        $request['settings']['vm_sendEmailOnNewMessage'],
                                        $request['settings']['vm_attachMessage'],
                                        $request['settings']['vm_sendEmailOnMissedCall']);
        $resident->save();

        $this->getUser()->setFlash('notice', 'resident.settings.successfull');
        $this->redirect('@resident_settings?residentid=' . $this->residentid);
      }
    }
  }
}
