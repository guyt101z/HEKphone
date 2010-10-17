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
  public function executeIndex(sfWebRequest $request)
  {
    $this->residents = Doctrine_Core::getTable('Residents')
      ->findCurrentResidents();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ResidentsForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ResidentsForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($residents = Doctrine_Core::getTable('Residents')->find(array($request->getParameter('id'))), sprintf('Object residents does not exist (%s).', $request->getParameter('id')));
    $this->form = new ResidentsForm($residents);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($residents = Doctrine_Core::getTable('Residents')->find(array($request->getParameter('id'))), sprintf('Object residents does not exist (%s).', $request->getParameter('id')));
    $this->form = new ResidentsForm($residents);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($residents = Doctrine_Core::getTable('Residents')->find(array($request->getParameter('id'))), sprintf('Object residents does not exist (%s).', $request->getParameter('id')));
    $residents->delete();

    $this->redirect('resident/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $residents = $form->save();

      #XXX: Insert asterisk connector HERE!

      $this->redirect('resident/edit?id='.$residents->getId());
    }
  }
}
