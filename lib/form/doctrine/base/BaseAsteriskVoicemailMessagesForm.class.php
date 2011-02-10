<?php

/**
 * AsteriskVoicemailMessages form base class.
 *
 * @method AsteriskVoicemailMessages getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAsteriskVoicemailMessagesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'msgnum'         => new sfWidgetFormInputText(),
      'dir'            => new sfWidgetFormInputText(),
      'context'        => new sfWidgetFormInputText(),
      'macrocontext'   => new sfWidgetFormInputText(),
      'callerid'       => new sfWidgetFormInputText(),
      'origtime'       => new sfWidgetFormInputText(),
      'duration'       => new sfWidgetFormInputText(),
      'flag'           => new sfWidgetFormInputText(),
      'mailboxuser'    => new sfWidgetFormInputText(),
      'mailboxcontext' => new sfWidgetFormInputText(),
      'recording'      => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'msgnum'         => new sfValidatorPass(array('required' => false)),
      'dir'            => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'context'        => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'macrocontext'   => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'callerid'       => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'origtime'       => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'duration'       => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'flag'           => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'mailboxuser'    => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'mailboxcontext' => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'recording'      => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('asterisk_voicemail_messages[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AsteriskVoicemailMessages';
  }

}
