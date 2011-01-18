<?php

/**
 * ResidentsGroupcalls form base class.
 *
 * @method ResidentsGroupcalls getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseResidentsGroupcallsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'resident_id'  => new sfWidgetFormInputHidden(),
      'groupcall_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'resident_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('resident_id')), 'empty_value' => $this->getObject()->get('resident_id'), 'required' => false)),
      'groupcall_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('groupcall_id')), 'empty_value' => $this->getObject()->get('groupcall_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('residents_groupcalls[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ResidentsGroupcalls';
  }

}
