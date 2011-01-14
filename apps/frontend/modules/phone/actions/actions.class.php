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
    $this->phones = Doctrine_Core::getTable('Phones')
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
      $this->forward404Unless($phone = Doctrine_Core::getTable('Phones')->findByRoomNo($request->getParameter('roomno')), sprintf('Object phones does not exist (%s).', $request->getParameter('roomno')));
    }
    elseif ($this->request->hasParameter('room'))
    {
      $this->forward404Unless($phone = Doctrine_Core::getTable('Phones')->findByRoomNo($request->getParameter('room')), sprintf('Object phones does not exist (%s).', $request->getParameter('room')));
    }
    elseif ($this->request->hasParameter('residentid'))
    {
      $this->forward404Unless($phone = Doctrine_Core::getTable('Phones')->findByResidentId($request->getParameter('residentid')), sprintf('Object phones does not exist (%s).', $request->getParameter('residentid')));
    }
    else
    {
      $this->forward404Unless($phone = Doctrine_Core::getTable('Phones')->find(array($request->getParameter('id'))), sprintf('Object phones does not exist (%s).', $request->getParameter('id')));
    }

    $this->form = new PhonesForm($phone);

    // get the room where the phone is located in.
    $selectOldRoomQuery  = Doctrine_Query::Create()->from('Rooms')->addWhere('phone = ?', $phone->getId());
    if($selectOldRoomQuery->count() > 1) {
      throw new Exception('Phone ' . $phone->getId() . ' is a quantum mechanical phone and exists in many rooms simultaneousely.');
    }
    $this->oldRoomRecord = $selectOldRoomQuery->fetchOne();

    if($this->oldRoomRecord)
      $this->form->setDefault('room', $this->oldRoomRecord->getId());
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($phones = Doctrine_Core::getTable('Phones')->find(array($request->getParameter('id'))), sprintf('Object phones does not exist (%s).', $request->getParameter('id')));
    $this->form = new PhonesForm($phones);

    $selectOldRoomQuery  = Doctrine_Query::Create()->from('Rooms')->addWhere('phone = ?', $phones->getId());
    if($selectOldRoomQuery->count() > 1) {
      throw new Exception('Phone ' . $phones->getId() . ' is a quantum mechanical phone and exists in many rooms simultaneousely.');
    }
    $this->oldRoomRecord = $selectOldRoomQuery->fetchOne();

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($phone = Doctrine_Core::getTable('Phones')->find(array($request->getParameter('id'))), sprintf('Object phones does not exist (%s).', $request->getParameter('id')));

    // delete any reference to the phone in the rooms table
    Doctrine_Query::Create()->update('Rooms')->set('phone', 'NULL')->where('phone = ?', $phone->getId())->execute();

    $phone->delete();

    $this->redirect('phone/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      // remove the phone from the rooms table (we'll add it later again)
      if($this->oldRoomRecord) {
        $this->oldRoomRecord->set('phone', null);
        $this->oldRoomRecord->save();
      }

      // save the form at this point to get an ID, if it's a new entry
      $phone = $form->save();

      // update the rooms table with the phones id
      $roomRecord = Doctrine_Core::getTable('Rooms')->findOneBy('id', $form->getValue('room'));
      $roomRecord->set('phone', $phone->getId());
      $roomRecord->save();

      // set the phones properties according to the room number
      $extension = '1' . str_pad($roomRecord->get('room_no'), 3, "0", STR_PAD_LEFT);
      $phone->set('name', $extension);
      $phone->set('callerid', $extension);
      $phone->set('defaultuser', $extension);
      $phone->set('defaultip', '192.168.' . substr($extension,1,1) . "." . (int)substr($extension,2,3));

      // set the phones properties according to who's living in the room
      try {
     	$resident = Doctrine_Core::getTable('Residents')->findByRoomNo($roomRecord->room_no);

      	$phone->set('callerid', $resident->first_name . " " . $resident->last_name . '<' . $extension . '>');
      	$phone->set('language', substr($resident->culture,0,2));
      	$phone->set('mailbox', $resident->id . "@default");
      }catch(Exception $e)
      {
        ;
      }

      $phone->save();
      $this->redirect('phone/edit?id='.$phone->getId());
    }
  }
}
