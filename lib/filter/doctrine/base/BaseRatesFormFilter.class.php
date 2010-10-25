<?php

/**
 * Rates filter form base class.
 *
 * @package    hekphone
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseRatesFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'provider'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Providers'), 'add_empty' => true)),
      'primary_time_begin'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'primary_time_rate'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'secondary_time_begin' => new sfWidgetFormFilterInput(),
      'secondary_time_rate'  => new sfWidgetFormFilterInput(),
      'weekend'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'week'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'pulsing'              => new sfWidgetFormChoice(array('choices' => array('' => '', '1/1' => '1/1', '60/60' => '60/60', '30/1' => '30/1', '60/1' => '60/1', '60/0' => '60/0'))),
      'name'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'provider'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Providers'), 'column' => 'id')),
      'primary_time_begin'   => new sfValidatorPass(array('required' => false)),
      'primary_time_rate'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'secondary_time_begin' => new sfValidatorPass(array('required' => false)),
      'secondary_time_rate'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'weekend'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'week'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'pulsing'              => new sfValidatorChoice(array('required' => false, 'choices' => array('1/1' => '1/1', '60/60' => '60/60', '30/1' => '30/1', '60/1' => '60/1', '60/0' => '60/0'))),
      'name'                 => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('rates_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Rates';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'provider'             => 'ForeignKey',
      'primary_time_begin'   => 'Text',
      'primary_time_rate'    => 'Number',
      'secondary_time_begin' => 'Text',
      'secondary_time_rate'  => 'Number',
      'weekend'              => 'Boolean',
      'week'                 => 'Boolean',
      'pulsing'              => 'Enum',
      'name'                 => 'Text',
    );
  }
}
