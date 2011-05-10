<?php

/**
 * Calls filter form base class.
 *
 * @package    hekphone
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCallsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'resident'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Residents'), 'add_empty' => true)),
      'extension'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'duration'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'destination'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'asterisk_uniqueid' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'charges'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'rate'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Rates'), 'add_empty' => true)),
      'bill'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Bills'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'resident'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Residents'), 'column' => 'id')),
      'extension'         => new sfValidatorPass(array('required' => false)),
      'date'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'duration'          => new sfValidatorPass(array('required' => false)),
      'destination'       => new sfValidatorPass(array('required' => false)),
      'asterisk_uniqueid' => new sfValidatorPass(array('required' => false)),
      'charges'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'rate'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Rates'), 'column' => 'id')),
      'bill'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Bills'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('calls_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Calls';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'resident'          => 'ForeignKey',
      'extension'         => 'Text',
      'date'              => 'Date',
      'duration'          => 'Text',
      'destination'       => 'Text',
      'asterisk_uniqueid' => 'Text',
      'charges'           => 'Number',
      'rate'              => 'ForeignKey',
      'bill'              => 'ForeignKey',
    );
  }
}
