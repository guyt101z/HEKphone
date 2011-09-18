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
      ->createQuery('p')
      ->leftJoin('p.Rooms r')
      ->orderBy('r.room_no')
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

    $selectOldRoomQuery  = Doctrine_Query::Create()->from('Rooms')->addWhere('phone = ?', $phone->getId());
    if($selectOldRoomQuery->count() > 1) {
      $this->getUser()->setFlash('notice', 'Phone ' . $phone->getId() . ' is a quantum mechanical phone and exists in many rooms simultaneousely. On submitting the form, all references will be deleted and the phone will be allocated to the room you choose.');
    }
    $this->oldRoomRecord = $selectOldRoomQuery->fetchOne();

    if($this->oldRoomRecord)
      $this->form->setDefault('room', $this->oldRoomRecord->getId());
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($phone = Doctrine_Core::getTable('Phones')->find(array($request->getParameter('id'))), sprintf('Object phones does not exist (%s).', $request->getParameter('id')));
    $this->form = new PhonesForm($phone);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeReset(sfWebRequest $request)
  {
    sfProjectConfiguration::getActive()->loadHelpers("Partial");

    $this->forward404Unless($phone = Doctrine_Core::getTable('Phones')->find(array($request->getParameter('id'))), sprintf('Object phone does not exist (%s).', $request->getParameter('id')));

    if($phone->uploadConfiguration($request->getParameter('overwritePersonalSettings', false), $request->getParameter('initialConfiguration',false))) {
        $this->getUser()->setFlash('notice', "phone.edit.reset.successful");
    }

    $this->form = new PhonesForm();

    $this->redirect('phone/edit?id=' . $request->getParameter('id'));
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless($phone = Doctrine_Core::getTable('Phones')->find(array($request->getParameter('id'))), sprintf('Object phones does not exist (%s).', $request->getParameter('id')));

    // delete any reference to the phone in the rooms table or we will violate a foreign key when deleting the phone
    Doctrine_Query::Create()
      ->update('Rooms')
      ->set('phone', 'NULL')
      ->where('phone = ?', $phone->getId())
      ->execute();

    $phone->delete();

    $this->redirect('phone/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      // If the phone is being newly created, we have no id yet. We save the form so we get an id.
      $phone = $form->save();

      /* Update the relation Phone<->Room... */
      // ... delete the extensions of the phone connected to the room
      Doctrine_Core::getTable('AsteriskExtensions')->deletePhonesExtensions($phone);
      // ... remove any reference to the phone
      Doctrine_Query::Create()
       ->update('Rooms')->set('phone', 'NULL')
       ->where('phone = ?', $phone->getId())
       ->execute();
      // ... reference the room at the correct room
      $room = Doctrine_Core::getTable('Rooms')->findOneBy('id', $form->getValue('room'));
      $room->set('phone', $phone->getId());
      $room->save();
      // ... update the phones object
      $phone->refreshRelated('Rooms');
      // ... insert new extension
      if( ! Doctrine_Core::getTable('AsteriskExtensions')->createPhonesExtensions($phone)) {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice') . PHP_EOL . " Creating Extensions failed. Phone is not reachable by number.");
      } else {
         $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice') . PHP_EOL . " Extensions of the phone updated.");
      }

      $phone->save();

      /* If the phone is a SIP-Phone, update the dhcp-server */
      if($form->getValue('mac') && $form->getValue('technology') == 'SIP') {
        chdir(sfConfig::get('sf_root_dir'));
        $formatter = new sfFormatter();
        $task = new hekphoneCreatedhcpconfigTask($this->dispatcher, $formatter);
        try {
          $task->run(array(), array('silent'));
        } catch (Exception $e) {
          //catch exceptions and "rethrow them as flash".
          $this->getUser()->setFlash('error', 'Saving the DHCP configuration failed: ' . $e->getMessage() . '');
        }
      }

      /* Notify the user and redirect back to the form */
      $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice') . PHP_EOL . " Update successful.");
      $this->redirect('phone/edit?id='.$phone->getId());
    }
  }
}
