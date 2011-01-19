<?php

/**
 * Groupcalls form.
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GroupcallsForm extends BaseGroupcallsForm
{
  public function configure()
  {
    // Fetch only who are living in a room and order by room number.
    $residentsListQuery = Doctrine_Query::create()->from('Residents residents')
            ->leftJoin('residents.Rooms room')
            ->select('residents.id, room.id, room.room_no, residents.first_name, residents.last_name')
            ->addWhere("room.room_no IS NOT NULL")
            ->addWhere("residents.move_in<= ?", date('Y-m-d'))
            ->addWhere("residents.move_out >= ? OR residents.move_out IS NULL", date('Y-m-d'))
            ->orderBy('room.room_no asc')
    ;
    $this->widgetSchema['residents_list']->addOption('query',$residentsListQuery);
  }
}
