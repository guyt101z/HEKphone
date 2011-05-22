<?php
/**
 * voicemail actions.
 *
 * @package    hekphone
 * @subpackage settings
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class voicemailActions extends sfActions
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

    if( $this->residentid != $this->getUser()->getAttribute('id') && ! $this->getUser()->hasCredential('hekphone'))
    {
      $this->forward('default', 'secure');
    }

    $this->forward404Unless($this->vmbox = VoicemessageFolder::getVoicemailbox($this->residentid), 'Voicemailbox ' .$this->residentid . ' not found');
  }

  public function executeDelete(sfWebRequest $request)
  {
    // the voicemailbox id equals per definition the id of the associated user
    // show 403-forbidden if someone tries to access anothers message and is not a member of hekphone.
    // TODO: move this to a filter
    if($request->getParameter('voicemailbox') != $this->getUser()->getAttribute('id') && ! $this->getUser()->hasCredential('hekphone'))
    {
      $this->forward('default', 'secure');
    }

    // get the voicemailbox
    $this->forward404Unless($vmbox = VoicemessageFolder::getVoicemailbox($request->getParameter('voicemailbox')), 'Voicemailbox ' . $request->getParameter('voicemailbox') . ' not found');

    // get the message
    if($request->getParameter('new')) {
      $message = $vmbox->getNewMessage($request->getParameter('id'));
    } else {
      $message = $vmbox->getOldMessage($request->getParameter('id'));
    }

    // delete the message
    if($message != false) {
      if($message->delete()) {
        $this->getUser()->setFlash('notice', 'voicemail.message.delete.successful');
      } else {
        $this->getUser()->setFlash('error', 'voicemail.message.delete.failed');
      }
    } else {
      $this->forward404('Voicemessage not found.');
    }

    $this->redirect('voicemail/index');
  }

  public function executeMarkAsOld(sfWebRequest $request){
    // the voicemailbox id equals per definition the id of the associated user
    // show 403-forbidden if someone tries to access anothers message and is not a member of hekphone.
    // TODO: move this to a filter
    if($request->getParameter('voicemailbox') != $this->getUser()->getAttribute('id') && ! $this->getUser()->hasCredential('hekphone'))
    {
      $this->forward('default', 'secure');
    }
    $this->forward404Unless($vmbox = VoicemessageFolder::getVoicemailbox($request->getParameter('voicemailbox')), 'Voicemailbox ' . $request->getParameter('voicemailbox') . ' not found');


    $message = $vmbox->getNewMessage($request->getParameter('id'));
    if($message->markAsOld()) {
      $this->getUser()->setFlash('notice' ,'voicemail.message.markAsOld.successful');
    } else {
      $this->getUser()->setFlash('error' ,'voicemail.message.markAsOld.failed');
    }
    $this->redirect('voicemail/index');
  }

  public function executeMarkAsNew(sfWebRequest $request){
      // the voicemailbox id equals per definition the id of the associated user
    // show 403-forbidden if someone tries to access anothers message and is not a member of hekphone.
    // TODO: move this to a filter
    if($request->getParameter('voicemailbox') != $this->getUser()->getAttribute('id') && ! $this->getUser()->hasCredential('hekphone'))
    {
      $this->forward('default', 'secure');
    }
    $this->forward404Unless($vmbox = VoicemessageFolder::getVoicemailbox($request->getParameter('voicemailbox')), 'Voicemailbox ' . $request->getParameter('voicemailbox') . ' not found');

    $message = $vmbox->getOldMessage($request->getParameter('id'));
    if($message->markAsNew()) {
      $this->getUser()->setFlash('notice' ,'voicemail.message.markAsOld.successful');
    } else {
      $this->getUser()->setFlash('error' ,'voicemail.message.markAsOld.failed');
    }
    $this->redirect('voicemail/index');;
  }

  public function executeListen(sfWebRequest $request) {
    // the voicemailbox id equals per definition the id of the associated user
    // show 403-forbidden if someone tries to access anothers message and is not a member of hekphone.
    // TODO: move this to a filter
    if($request->getParameter('voicemailbox') != $this->getUser()->getAttribute('id') && ! $this->getUser()->hasCredential('hekphone'))
    {
      $this->forward('default', 'secure');
    }

    // get the voicemailbox
    $this->forward404Unless($vmbox = VoicemessageFolder::getVoicemailbox($request->getParameter('voicemailbox')), 'Voicemailbox ' . $request->getParameter('voicemailbox') . ' not found');

    // get the message
    if($request->getParameter('new')) {
      $message = $vmbox->getNewMessage($request->getParameter('id'));
    } else {
      $message = $vmbox->getOldMessage($request->getParameter('id'));
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $message->getSoundFilename());

    $response = $this->getResponse();
    $response->setContentType($mimeType);
    $response->setHttpHeader('Content-Disposition', 'attachment; filename=' . basename($message->getSoundFilename()));
    $response->setHttpHeader('Content-Length', filesize($message->getSoundFilename()));
    $response->setContent(file_get_contents($message->getSoundFilename()));
    return sfView::NONE;
  }
}