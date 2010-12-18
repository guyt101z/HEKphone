<?php

/**
 * ResidentsTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ResidentsTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object ResidentsTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Residents');
    }

    /**
     * @param integer $roomNo  Room No; format: NNNN (n=[0..9])
     * @param string $date     Date at which to look for the user: default = now
     * @return Doctrine_Record
     */
    function findByRoomNo($roomNo, $date = "now") {
        if ($date == "now")
            $date = date("Y-m-d", time());

        $q = Doctrine_Query::create()
            ->from('Residents residents')
            ->leftJoin('residents.Rooms rooms')
            ->addWhere("rooms.room_no = ? and rooms.room_no IS NOT NULL", $roomNo)
            ->addWhere("residents.move_in<= ?", $date)
            ->addWhere("residents.move_out >= ? OR residents.move_out IS NULL", $date);

        if ($q->count()>0) {
            return $q->fetchOne();
        } elseif($q->count()>1) {
            throw New Exception("According to the database there is more than one person living in room no $roomNo at $date.");
        } else {
            throw New Exception("Unable to find a resident living in room no $roomNo at $date.");
        }
    }

     /**
     * Gets a list (collection) of all users which had a room associated at the given
     * time.
     * @param string $orderby  Order by this field; default = room
     * @param string $date     Date at which to look for the user; default = now
     * @return Doctrine_Collection
     */
    public function findCurrentResidents($orderby = 'rooms.room_no', $date = "now") {
        if ($date == "now")
            $date = date("Y-m-d", time());
        $residents = Doctrine_Query::create()
            ->from('Residents r')
            ->leftJoin('r.Rooms rooms')
            ->addWhere("r.room != 0")
            ->addWhere("r.move_in<= ?", $date)
            ->addWhere("r.move_out >= ? OR r.move_out IS NULL", $date)
            ->orderBy($orderby)
            ->execute();

        return $residents;
    }

    public function findResidentsMovingOutTomorrow() {
        $tomorrow = date("Y-m-d", strtotime("+1 day", strtotime(date("Y-m-d"))));
        return $this->createQuery()
           ->where('move_out = ?', $tomorrow)
           ->execute();
    }

    public function findResidentsMovingOutToday() {
        return $this->createQuery()
            ->where('move_out = ?', date("Y-m-d"))
            ->execute();
    }
}