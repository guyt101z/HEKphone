<?php

/**
 * groupcalls actions.
 *
 * @package    hekphone
 * @subpackage groupcalls
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class groupcallsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->Groupcalls = Doctrine_Core::getTable('Groupcalls')
      ->createQuery('a')
      ->orderBy('extension asc')
      ->execute();
  }


  public function executeNew(sfWebRequest $request)
  {
    $this->form = new GroupcallsForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new GroupcallsForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($Groupcall = Doctrine_Core::getTable('Groupcalls')->find(array($request->getParameter('id'))), sprintf('Object Groupcall does not exist (%s).', $request->getParameter('id')));
    $this->form = new GroupcallsForm($Groupcall);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Groupcall = Doctrine_Core::getTable('Groupcalls')->find(array($request->getParameter('id'))), sprintf('Object Groupcall does not exist (%s).', $request->getParameter('id')));
    $this->form = new GroupcallsForm($Groupcall);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($groupcall = Doctrine_Core::getTable('Groupcalls')->find(array($request->getParameter('id'))), sprintf('Object Groupcall does not exist (%s).', $request->getParameter('id')));
    $groupcall->delete();

    $this->redirect('groupcalls');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      /* Check if the extension provided collides with a rooms extension */
      $roomQuery = Doctrine_Query::create()
          ->from('Rooms')
          ->where('room_no = ?', substr($form->getValue('extension'),1, strlen($form->getValue('extension'))));
      if($roomQuery->count() > 0){
        $this->getUser()->setFlash('error', 'There\'s a room which has the same extension as the groupcall. Changes not applied.');
        return sfView::SUCCESS;
      }

      $groupcall = $form->save();

      /* Update AsteriskExtensions, so the groupcall can be called */
      Doctrine_Core::getTable('AsteriskExtensions')->deleteExtension($form->getValue('extension'));
      $extensions = Doctrine_Collection::create('AsteriskExtensions');
      $extensions->fromArray($groupcall->getExtensionsAsArray());
      $extensions->save();

      $this->getUser()->setFlash('notice', 'Groupcall successfully updated.');
      $this->redirect('groupcall_edit', array('id' => $groupcall->getId()));
    }
  }
}
