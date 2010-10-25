<?php

/**
 * Calls form base class.
 *
 * @method Calls getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCallsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'resident'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Residents'), 'add_empty' => false)),
      'extension'   => new sfWidgetFormInputText(),
      'date'        => new sfWidgetFormDateTime(),
      'duration'    => new sfWidgetFormInputText(),
      'destination' => new sfWidgetFormInputText(),
      'charges'     => new sfWidgetFormInputText(),
      'rate'        => new sfWidgetFormInputText(),
      'bill'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'resident'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Residents'))),
      'extension'   => new sfValidatorString(array('max_length' => 10)),
      'date'        => new sfValidatorDateTime(array('required' => false)),
      'duration'    => new sfValidatorString(array('max_length' => 6)),
      'destination' => new sfValidatorString(array('max_length' => 50)),
      'charges'     => new sfValidatorNumber(),
      'rate'        => new sfValidatorInteger(),
      'bill'        => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('calls[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Calls';
  }

}
