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

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($resident = Doctrine_Core::getTable('Residents')->find(array($request->getParameter('residentid'))), sprintf('Object residents does not exist (%s).', $request->getParameter('residentid')));
    $this->form = new ResidentsForm($resident);

    // We the field is empty, the passwort remains unchanged (see Resident->setPassword())
    $this->form['password']->getWidget()->setAttribute('value', '');

    // So we can access the resident's data from the template/view layer
    $this->resident = $resident;
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($resident = Doctrine_Core::getTable('Residents')->find(array($request->getParameter('residentid'))), sprintf('Object residents does not exist (%s).', $request->getParameter('residentid')));
    $this->form = new ResidentsForm($resident);

    $this->resident = $resident;

    $this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $residents = $form->save();

      #XXX: Insert asterisk connector HERE!

      $this->getUser()->setFlash('notice', 'resident.edit.successfull');
      $this->redirect('@resident_edit?residentid='.$residents->getId());
    }
  }
}
