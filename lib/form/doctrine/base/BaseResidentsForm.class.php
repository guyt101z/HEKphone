<?php

/**
 * Residents form base class.
 *
 * @method Residents getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseResidentsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'last_name'               => new sfWidgetFormInputText(),
      'first_name'              => new sfWidgetFormInputText(),
      'email'                   => new sfWidgetFormInputText(),
      'move_in'                 => new sfWidgetFormDate(),
      'move_out'                => new sfWidgetFormDate(),
      'bill_limit'              => new sfWidgetFormInputText(),
      'room'                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Rooms'), 'add_empty' => true)),
      'warning1'                => new sfWidgetFormInputCheckbox(),
      'warning2'                => new sfWidgetFormInputCheckbox(),
      'unlocked'                => new sfWidgetFormInputCheckbox(),
      'shortened_itemized_bill' => new sfWidgetFormInputCheckbox(),
      'account_number'          => new sfWidgetFormInputText(),
      'bank_number'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Banks'), 'add_empty' => true)),
      'password'                => new sfWidgetFormInputText(),
      'hekphone'                => new sfWidgetFormInputCheckbox(),
      'culture'                 => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'last_name'               => new sfValidatorString(array('max_length' => 50)),
      'first_name'              => new sfValidatorString(array('max_length' => 50)),
      'email'                   => new sfValidatorEmail(array('max_length' => 255, 'required' => false)),
      'move_in'                 => new sfValidatorDate(),
      'move_out'                => new sfValidatorDate(array('required' => false)),
      'bill_limit'              => new sfValidatorInteger(array('required' => false)),
      'room'                    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Rooms'), 'required' => false)),
      'warning1'                => new sfValidatorBoolean(array('required' => false)),
      'warning2'                => new sfValidatorBoolean(array('required' => false)),
      'unlocked'                => new sfValidatorBoolean(array('required' => false)),
      'shortened_itemized_bill' => new sfValidatorBoolean(array('required' => false)),
      'account_number'          => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'bank_number'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Banks'), 'required' => false)),
      'password'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'hekphone'                => new sfValidatorBoolean(array('required' => false)),
      'culture'                 => new sfValidatorString(array('max_length' => 5, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Residents', 'column' => array('room')))
    );

    $this->widgetSchema->setNameFormat('residents[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Residents';
  }

}
