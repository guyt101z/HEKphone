<?php

/**
 * HekdbCurrentResidents form base class.
 *
 * @method HekdbCurrentResidents getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseHekdbCurrentResidentsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'first_name' => new sfWidgetFormTextarea(),
      'last_name'  => new sfWidgetFormTextarea(),
      'id'         => new sfWidgetFormInputHidden(),
      'room_no'    => new sfWidgetFormTextarea(),
      'move_in'    => new sfWidgetFormDate(),
      'move_out'   => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'first_name' => new sfValidatorString(array('required' => false)),
      'last_name'  => new sfValidatorString(array('required' => false)),
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'room_no'    => new sfValidatorString(array('required' => false)),
      'move_in'    => new sfValidatorDate(array('required' => false)),
      'move_out'   => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('hekdb_current_residents[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'HekdbCurrentResidents';
  }

}
