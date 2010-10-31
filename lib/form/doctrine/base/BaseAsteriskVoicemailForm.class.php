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
      'id'             => new sfWidgetFormInputHidden(),
      'uniqueid'       => new sfWidgetFormInputText(),
      'customer_id'    => new sfWidgetFormInputText(),
      'context'        => new sfWidgetFormInputText(),
      'mailbox'        => new sfWidgetFormInputText(),
      'password'       => new sfWidgetFormInputText(),
      'fullname'       => new sfWidgetFormInputText(),
      'email'          => new sfWidgetFormInputText(),
      'pager'          => new sfWidgetFormInputText(),
      'tz'             => new sfWidgetFormInputText(),
      'attach'         => new sfWidgetFormInputText(),
      'saycid'         => new sfWidgetFormInputText(),
      'dialout'        => new sfWidgetFormInputText(),
      'callback'       => new sfWidgetFormInputText(),
      'review'         => new sfWidgetFormInputText(),
      'operator'       => new sfWidgetFormInputText(),
      'envelope'       => new sfWidgetFormInputText(),
      'sayduration'    => new sfWidgetFormInputText(),
      'saydurationm'   => new sfWidgetFormInputText(),
      'sendvoicemail'  => new sfWidgetFormInputText(),
      'delete'         => new sfWidgetFormInputText(),
      'nextaftercmd'   => new sfWidgetFormInputText(),
      'forcename'      => new sfWidgetFormInputText(),
      'forcegreetings' => new sfWidgetFormInputText(),
      'hidefromdir'    => new sfWidgetFormInputText(),
      'stamp'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'uniqueid'       => new sfValidatorInteger(),
      'customer_id'    => new sfValidatorString(array('max_length' => 11, 'required' => false)),
      'context'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'mailbox'        => new sfValidatorString(array('max_length' => 11, 'required' => false)),
      'password'       => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'fullname'       => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'email'          => new sfValidatorEmail(array('max_length' => 50)),
      'pager'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'tz'             => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'attach'         => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'saycid'         => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'dialout'        => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'callback'       => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'review'         => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'operator'       => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'envelope'       => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'sayduration'    => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'saydurationm'   => new sfValidatorInteger(array('required' => false)),
      'sendvoicemail'  => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'delete'         => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'nextaftercmd'   => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'forcename'      => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'forcegreetings' => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'hidefromdir'    => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'stamp'          => new sfValidatorDateTime(array('required' => false)),
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
