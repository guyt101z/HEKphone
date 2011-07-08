<?php

/**
 * Agencys form base class.
 *
 * @method Agencys getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAgencysForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'name'      => new sfWidgetFormInputText(),
      'postcode'  => new sfWidgetFormInputText(),
      'city'      => new sfWidgetFormInputText(),
      'shortterm' => new sfWidgetFormInputText(),
      'bank'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Banks'), 'add_empty' => true)),
      'pan'       => new sfWidgetFormInputText(),
      'bic'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'      => new sfValidatorString(array('max_length' => 58)),
      'postcode'  => new sfValidatorString(array('max_length' => 5)),
      'city'      => new sfValidatorString(array('max_length' => 35)),
      'shortterm' => new sfValidatorString(array('max_length' => 27)),
      'bank'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Banks'), 'required' => false)),
      'pan'       => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'bic'       => new sfValidatorString(array('max_length' => 11, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Agencys', 'column' => array('id')))
    );

    $this->widgetSchema->setNameFormat('agencys[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Agencys';
  }

}
