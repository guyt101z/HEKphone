<?php

/**
 * AsteriskVoicemailMessages filter form base class.
 *
 * @package    hekphone
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAsteriskVoicemailMessagesFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'msgnum'         => new sfWidgetFormFilterInput(),
      'dir'            => new sfWidgetFormFilterInput(),
      'context'        => new sfWidgetFormFilterInput(),
      'macrocontext'   => new sfWidgetFormFilterInput(),
      'callerid'       => new sfWidgetFormFilterInput(),
      'origtime'       => new sfWidgetFormFilterInput(),
      'duration'       => new sfWidgetFormFilterInput(),
      'flag'           => new sfWidgetFormFilterInput(),
      'mailboxuser'    => new sfWidgetFormFilterInput(),
      'mailboxcontext' => new sfWidgetFormFilterInput(),
      'recording'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'msgnum'         => new sfValidatorPass(array('required' => false)),
      'dir'            => new sfValidatorPass(array('required' => false)),
      'context'        => new sfValidatorPass(array('required' => false)),
      'macrocontext'   => new sfValidatorPass(array('required' => false)),
      'callerid'       => new sfValidatorPass(array('required' => false)),
      'origtime'       => new sfValidatorPass(array('required' => false)),
      'duration'       => new sfValidatorPass(array('required' => false)),
      'flag'           => new sfValidatorPass(array('required' => false)),
      'mailboxuser'    => new sfValidatorPass(array('required' => false)),
      'mailboxcontext' => new sfValidatorPass(array('required' => false)),
      'recording'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('asterisk_voicemail_messages_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AsteriskVoicemailMessages';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'msgnum'         => 'Text',
      'dir'            => 'Text',
      'context'        => 'Text',
      'macrocontext'   => 'Text',
      'callerid'       => 'Text',
      'origtime'       => 'Text',
      'duration'       => 'Text',
      'flag'           => 'Text',
      'mailboxuser'    => 'Text',
      'mailboxcontext' => 'Text',
      'recording'      => 'Text',
    );
  }
}
