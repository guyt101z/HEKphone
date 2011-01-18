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
      'uniqueid'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Residents'), 'add_empty' => true)),
      'customer_id'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'context'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mailbox'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'password'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fullname'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pager'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tz'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'attach'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'saycid'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'dialout'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'callback'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'review'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'operator'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'envelope'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sayduration'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'saydurationm'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sendvoicemail'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'delete'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nextaftercmd'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'forcename'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'forcegreetings' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'hidefromdir'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'minsecs'        => new sfWidgetFormFilterInput(),
      'stamp'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'uniqueid'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Residents'), 'column' => 'id')),
      'customer_id'    => new sfValidatorPass(array('required' => false)),
      'context'        => new sfValidatorPass(array('required' => false)),
      'mailbox'        => new sfValidatorPass(array('required' => false)),
      'password'       => new sfValidatorPass(array('required' => false)),
      'fullname'       => new sfValidatorPass(array('required' => false)),
      'email'          => new sfValidatorPass(array('required' => false)),
      'pager'          => new sfValidatorPass(array('required' => false)),
      'tz'             => new sfValidatorPass(array('required' => false)),
      'attach'         => new sfValidatorPass(array('required' => false)),
      'saycid'         => new sfValidatorPass(array('required' => false)),
      'dialout'        => new sfValidatorPass(array('required' => false)),
      'callback'       => new sfValidatorPass(array('required' => false)),
      'review'         => new sfValidatorPass(array('required' => false)),
      'operator'       => new sfValidatorPass(array('required' => false)),
      'envelope'       => new sfValidatorPass(array('required' => false)),
      'sayduration'    => new sfValidatorPass(array('required' => false)),
      'saydurationm'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sendvoicemail'  => new sfValidatorPass(array('required' => false)),
      'delete'         => new sfValidatorPass(array('required' => false)),
      'nextaftercmd'   => new sfValidatorPass(array('required' => false)),
      'forcename'      => new sfValidatorPass(array('required' => false)),
      'forcegreetings' => new sfValidatorPass(array('required' => false)),
      'hidefromdir'    => new sfValidatorPass(array('required' => false)),
      'minsecs'        => new sfValidatorPass(array('required' => false)),
      'stamp'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
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
      'id'             => 'Number',
      'uniqueid'       => 'ForeignKey',
      'customer_id'    => 'Text',
      'context'        => 'Text',
      'mailbox'        => 'Text',
      'password'       => 'Text',
      'fullname'       => 'Text',
      'email'          => 'Text',
      'pager'          => 'Text',
      'tz'             => 'Text',
      'attach'         => 'Text',
      'saycid'         => 'Text',
      'dialout'        => 'Text',
      'callback'       => 'Text',
      'review'         => 'Text',
      'operator'       => 'Text',
      'envelope'       => 'Text',
      'sayduration'    => 'Text',
      'saydurationm'   => 'Number',
      'sendvoicemail'  => 'Text',
      'delete'         => 'Text',
      'nextaftercmd'   => 'Text',
      'forcename'      => 'Text',
      'forcegreetings' => 'Text',
      'hidefromdir'    => 'Text',
      'minsecs'        => 'Text',
      'stamp'          => 'Date',
    );
  }
}
