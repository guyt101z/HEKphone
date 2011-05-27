<?php

/**
 * Bills filter form base class.
 *
 * @package    hekphone
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseBillsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'resident'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Residents'), 'add_empty' => true)),
      'date'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'billingperiod_start' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'billingperiod_end'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'amount'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'debit_failed'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'manually_created'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'resident'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Residents'), 'column' => 'id')),
      'date'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'billingperiod_start' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'billingperiod_end'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'amount'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'debit_failed'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'manually_created'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('bills_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Bills';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'resident'            => 'ForeignKey',
      'date'                => 'Date',
      'billingperiod_start' => 'Date',
      'billingperiod_end'   => 'Date',
      'amount'              => 'Number',
      'debit_failed'        => 'Boolean',
      'manually_created'    => 'Boolean',
    );
  }
}
