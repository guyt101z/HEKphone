<?php

/**
 * Bills form base class.
 *
 * @method Bills getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseBillsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'resident'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Residents'), 'add_empty' => false)),
      'date'         => new sfWidgetFormDate(),
      'amount'       => new sfWidgetFormInputText(),
      'debit_failed' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'resident'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Residents'))),
      'date'         => new sfValidatorDate(),
      'amount'       => new sfValidatorNumber(),
      'debit_failed' => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('bills[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Bills';
  }

}
