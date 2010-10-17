<?php

/**
 * AsteriskVoicemail form base class.
 *
 * @method AsteriskVoicemail getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAsteriskVoicemailForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputText(),
      'customer_id' => new sfWidgetFormInputText(),
      'context'     => new sfWidgetFormTextarea(),
      'mailbox'     => new sfWidgetFormInputText(),
      'password'    => new sfWidgetFormTextarea(),
      'fullname'    => new sfWidgetFormTextarea(),
      'email'       => new sfWidgetFormTextarea(),
      'pager'       => new sfWidgetFormTextarea(),
      'stamp'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorInteger(),
      'customer_id' => new sfValidatorInteger(array('required' => false)),
      'context'     => new sfValidatorString(),
      'mailbox'     => new sfValidatorInteger(array('required' => false)),
      'password'    => new sfValidatorString(array('required' => false)),
      'fullname'    => new sfValidatorString(),
      'email'       => new sfValidatorString(),
      'pager'       => new sfValidatorString(),
      'stamp'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('asterisk_voicemail[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AsteriskVoicemail';
  }

}
