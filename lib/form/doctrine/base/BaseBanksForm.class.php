<?php

/**
 * Banks form base class.
 *
 * @method Banks getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseBanksForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'bank_number' => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormInputText(),
      'zip'         => new sfWidgetFormInputText(),
      'locality'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'bank_number' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('bank_number')), 'empty_value' => $this->getObject()->get('bank_number'), 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 80)),
      'zip'         => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'locality'    => new sfValidatorString(array('max_length' => 80, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Banks', 'column' => array('bank_number')))
    );

    $this->widgetSchema->setNameFormat('banks[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Banks';
  }

}
