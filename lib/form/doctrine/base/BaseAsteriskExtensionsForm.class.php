<?php

/**
 * AsteriskExtensions form base class.
 *
 * @method AsteriskExtensions getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAsteriskExtensionsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'context'  => new sfWidgetFormTextarea(),
      'exten'    => new sfWidgetFormTextarea(),
      'priority' => new sfWidgetFormInputText(),
      'app'      => new sfWidgetFormTextarea(),
      'appdata'  => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'context'  => new sfValidatorString(),
      'exten'    => new sfValidatorString(),
      'priority' => new sfValidatorInteger(array('required' => false)),
      'app'      => new sfValidatorString(),
      'appdata'  => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('asterisk_extensions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AsteriskExtensions';
  }

}
