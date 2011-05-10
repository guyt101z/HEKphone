<?php

/**
 * AsteriskCdr filter form base class.
 *
 * @package    hekphone
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAsteriskCdrFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'calldate'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'clid'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'src'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'dst'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'dcontext'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'channel'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'dstchannel'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'lastapp'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'lastdata'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'duration'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'billsec'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'disposition' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'amaflags'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'accountcode' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'uniqueid'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'userfield'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'calldate'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'clid'        => new sfValidatorPass(array('required' => false)),
      'src'         => new sfValidatorPass(array('required' => false)),
      'dst'         => new sfValidatorPass(array('required' => false)),
      'dcontext'    => new sfValidatorPass(array('required' => false)),
      'channel'     => new sfValidatorPass(array('required' => false)),
      'dstchannel'  => new sfValidatorPass(array('required' => false)),
      'lastapp'     => new sfValidatorPass(array('required' => false)),
      'lastdata'    => new sfValidatorPass(array('required' => false)),
      'duration'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'billsec'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'disposition' => new sfValidatorPass(array('required' => false)),
      'amaflags'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'accountcode' => new sfValidatorPass(array('required' => false)),
      'uniqueid'    => new sfValidatorPass(array('required' => false)),
      'userfield'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('asterisk_cdr_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AsteriskCdr';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'calldate'    => 'Date',
      'clid'        => 'Text',
      'src'         => 'Text',
      'dst'         => 'Text',
      'dcontext'    => 'Text',
      'channel'     => 'Text',
      'dstchannel'  => 'Text',
      'lastapp'     => 'Text',
      'lastdata'    => 'Text',
      'duration'    => 'Number',
      'billsec'     => 'Number',
      'disposition' => 'Text',
      'amaflags'    => 'Number',
      'accountcode' => 'Text',
      'uniqueid'    => 'Text',
      'userfield'   => 'Text',
    );
  }
}
