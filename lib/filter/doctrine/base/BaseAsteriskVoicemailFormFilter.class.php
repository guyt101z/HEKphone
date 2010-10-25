<?php

/**
 * AsteriskVoicemail filter form base class.
 *
 * @package    hekphone
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAsteriskVoicemailFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'customer_id' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'context'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mailbox'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'password'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fullname'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pager'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'stamp'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'customer_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'context'     => new sfValidatorPass(array('required' => false)),
      'mailbox'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'password'    => new sfValidatorPass(array('required' => false)),
      'fullname'    => new sfValidatorPass(array('required' => false)),
      'email'       => new sfValidatorPass(array('required' => false)),
      'pager'       => new sfValidatorPass(array('required' => false)),
      'stamp'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('asterisk_voicemail_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AsteriskVoicemail';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'customer_id' => 'Number',
      'context'     => 'Text',
      'mailbox'     => 'Number',
      'password'    => 'Text',
      'fullname'    => 'Text',
      'email'       => 'Text',
      'pager'       => 'Text',
      'stamp'       => 'Date',
    );
  }
}
