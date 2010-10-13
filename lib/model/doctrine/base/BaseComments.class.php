<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Comments', 'hekphone');

/**
 * BaseComments
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $resident
 * @property timestamp $stamp
 * @property string $comment
 * @property Residents $Residents
 * 
 * @method integer   getResident()  Returns the current record's "resident" value
 * @method timestamp getStamp()     Returns the current record's "stamp" value
 * @method string    getComment()   Returns the current record's "comment" value
 * @method Residents getResidents() Returns the current record's "Residents" value
 * @method Comments  setResident()  Sets the current record's "resident" value
 * @method Comments  setStamp()     Sets the current record's "stamp" value
 * @method Comments  setComment()   Sets the current record's "comment" value
 * @method Comments  setResidents() Sets the current record's "Residents" value
 * 
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseComments extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('comments');
        $this->hasColumn('resident', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('stamp', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             'default' => 'now()',
             ));
        $this->hasColumn('comment', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Residents', array(
             'local' => 'resident',
             'foreign' => 'id'));
    }
}