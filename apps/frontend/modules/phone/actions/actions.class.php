<?php

/**
 * phone actions.
 *
 * @package    hekphone
 * @subpackage phone
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class phoneActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->phoness = Doctrine_Core::getTable('Phones')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PhonesForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PhonesForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    if ($this->request->hasParameter('roomno'))
    {
      $this->forward404Unless($phones = Doctrine_Core::getTable('Phones')->findByRoomNo($request->getParameter('roomno')), sprintf('Object phones does not exist (%s).', $request->getParameter('roomno')));
    }
    elseif ($this->request->hasParameter('room'))
    {
      $this->forward404Unless($phones = Doctrine_Core::getTable('Phones')->findByRoomNo($request->getParameter('room')), sprintf('Object phones does not exist (%s).', $request->getParameter('room')));
    }
    elseif ($this->request->hasParameter('residentid'))
    {
      $this->forward404Unless($phones = Doctrine_Core::getTable('Phones')->findByResidentId($request->getParameter('residentid')), sprintf('Object phones does not exist (%s).', $request->getParameter('residentid')));
    }
    else
    {
      $this->forward404Unless($phones = Doctrine_Core::getTable('Phones')->find(array($request->getParameter('id'))), sprintf('Object phones does not exist (%s).', $request->getParameter('id')));
    }

    $this->form = new PhonesForm($phones);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($phones = Doctrine_Core::getTable('Phones')->find(array($request->getParameter('id'))), sprintf('Object phones does not exist (%s).', $request->getParameter('id')));
    $this->form = new PhonesForm($phones);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($phones = Doctrine_Core::getTable('Phones')->find(array($request->getParameter('id'))), sprintf('Object phones does not exist (%s).', $request->getParameter('id')));
    $phones->delete();

    $this->redirect('phone/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $phones = $form->save();

      $this->redirect('phone/edit?id='.$phones->getId());
    }
  }
}
