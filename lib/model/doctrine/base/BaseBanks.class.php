<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Banks', 'hekphone');

/**
 * BaseBanks
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $bank_number
 * @property string $name
 * @property string $zip
 * @property string $locality
 * @property Doctrine_Collection $Residents
 * 
 * @method string              getBankNumber()  Returns the current record's "bank_number" value
 * @method string              getName()        Returns the current record's "name" value
 * @method string              getZip()         Returns the current record's "zip" value
 * @method string              getLocality()    Returns the current record's "locality" value
 * @method Doctrine_Collection getResidents()   Returns the current record's "Residents" collection
 * @method Banks               setBankNumber()  Sets the current record's "bank_number" value
 * @method Banks               setName()        Sets the current record's "name" value
 * @method Banks               setZip()         Sets the current record's "zip" value
 * @method Banks               setLocality()    Sets the current record's "locality" value
 * @method Banks               setResidents()   Sets the current record's "Residents" collection
 * 
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBanks extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('banks');
        $this->hasColumn('bank_number', 'string', null, array(
             'type' => 'string',
             'primary' => true,
             'unique' => true,
             ));
        $this->hasColumn('name', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('zip', 'string', null, array(
             'type' => 'string',
             'fixed' => 1,
             ));
        $this->hasColumn('locality', 'string', null, array(
             'type' => 'string',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Residents', array(
             'local' => 'bank_number',
             'foreign' => 'bank_number'));
    }
}