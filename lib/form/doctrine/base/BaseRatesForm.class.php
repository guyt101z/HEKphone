<?php

/**
 * Rates form base class.
 *
 * @method Rates getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRatesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'provider'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Providers'), 'add_empty' => false)),
      'primary_time_begin'   => new sfWidgetFormTime(),
      'primary_time_rate'    => new sfWidgetFormInputText(),
      'secondary_time_begin' => new sfWidgetFormTime(),
      'secondary_time_rate'  => new sfWidgetFormInputText(),
      'weekend'              => new sfWidgetFormInputCheckbox(),
      'week'                 => new sfWidgetFormInputCheckbox(),
      'pulsing'              => new sfWidgetFormChoice(array('choices' => array('1/1' => '1/1', '60/60' => '60/60', '30/1' => '30/1', '60/1' => '60/1', '60/0' => '60/0'))),
      'name'                 => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'provider'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Providers'))),
      'primary_time_begin'   => new sfValidatorTime(),
      'primary_time_rate'    => new sfValidatorNumber(),
      'secondary_time_begin' => new sfValidatorTime(array('required' => false)),
      'secondary_time_rate'  => new sfValidatorNumber(array('required' => false)),
      'weekend'              => new sfValidatorBoolean(array('required' => false)),
      'week'                 => new sfValidatorBoolean(array('required' => false)),
      'pulsing'              => new sfValidatorChoice(array('choices' => array(0 => '1/1', 1 => '60/60', 2 => '30/1', 3 => '60/1', 4 => '60/0'))),
      'name'                 => new sfValidatorString(array('max_length' => 80)),
    ));

    $this->widgetSchema->setNameFormat('rates[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Rates';
  }

}
