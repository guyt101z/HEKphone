<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Regions', 'hekphone');

/**
 * BaseRegions
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Doctrine_Collection $RatesRegions
 * @property Doctrine_Collection $Prefixes
 * 
 * @method integer             getId()           Returns the current record's "id" value
 * @method string              getName()         Returns the current record's "name" value
 * @method Doctrine_Collection getRatesRegions() Returns the current record's "RatesRegions" collection
 * @method Doctrine_Collection getPrefixes()     Returns the current record's "Prefixes" collection
 * @method Regions             setId()           Sets the current record's "id" value
 * @method Regions             setName()         Sets the current record's "name" value
 * @method Regions             setRatesRegions() Sets the current record's "RatesRegions" collection
 * @method Regions             setPrefixes()     Sets the current record's "Prefixes" collection
 * 
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseRegions extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('regions');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('name', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('RatesRegions', array(
             'local' => 'id',
             'foreign' => 'region'));

        $this->hasMany('Prefixes', array(
             'local' => 'id',
             'foreign' => 'region'));
    }
}