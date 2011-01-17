<?php

/**
 * Phones
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Phones extends BasePhones
{
  /**
   * Update the phones details according to the room where it's currently located in.
   *
   * @param $room Doctrine_Record of the room where the phone is located
   * @return unknown
   */
  public function updateForRoom($room) {
      $extension = '1' . str_pad($room->get('room_no'), 3, "0", STR_PAD_LEFT);
      $this->set('name', $extension);
      $this->set('callerid', $extension);
      $this->set('defaultuser', $extension);
      $this->set('defaultip', '192.168.' . substr($extension,1,1) . "." . (int)substr($extension,2,3));

      return $this;
  }

  /**
   * Update the phones details according to who lives in the room. If the room is not inhabitated nothing is set.
   *
   * @param $resident Doctrine_Record of the resident
   * @return unknown
   */
  public function updateForResident($resident) {
      $this->set('callerid', $resident->first_name . " " . $resident->last_name . ' <' . $this->name . '>');
      $this->set('language', substr($resident->culture,0,2));
      $this->set('mailbox', $resident->id . "@default");

      return $this;
  }
}
