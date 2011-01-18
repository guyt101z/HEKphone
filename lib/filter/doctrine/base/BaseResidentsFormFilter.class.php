<?php

/**
 * Residents filter form base class.
 *
 * @package    hekphone
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseResidentsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'last_name'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'first_name'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'                   => new sfWidgetFormFilterInput(),
      'move_in'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'move_out'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'bill_limit'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'room'                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Rooms'), 'add_empty' => true)),
      'warning1'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'warning2'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'unlocked'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'vm_active'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'vm_seconds'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mail_on_missed_call'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'shortened_itemized_bill' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'account_number'          => new sfWidgetFormFilterInput(),
      'bank_number'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Banks'), 'add_empty' => true)),
      'password'                => new sfWidgetFormFilterInput(),
      'hekphone'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'culture'                 => new sfWidgetFormFilterInput(),
      'groupcalls_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Groupcalls')),
    ));

    $this->setValidators(array(
      'last_name'               => new sfValidatorPass(array('required' => false)),
      'first_name'              => new sfValidatorPass(array('required' => false)),
      'email'                   => new sfValidatorPass(array('required' => false)),
      'move_in'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'move_out'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'bill_limit'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'room'                    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Rooms'), 'column' => 'id')),
      'warning1'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'warning2'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'unlocked'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'vm_active'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'vm_seconds'              => new sfValidatorPass(array('required' => false)),
      'mail_on_missed_call'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'shortened_itemized_bill' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'account_number'          => new sfValidatorPass(array('required' => false)),
      'bank_number'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Banks'), 'column' => 'bank_number')),
      'password'                => new sfValidatorPass(array('required' => false)),
      'hekphone'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'culture'                 => new sfValidatorPass(array('required' => false)),
      'groupcalls_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Groupcalls', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('residents_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addGroupcallsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.ResidentsGroupcalls ResidentsGroupcalls')
      ->andWhereIn('ResidentsGroupcalls.groupcall_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Residents';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'last_name'               => 'Text',
      'first_name'              => 'Text',
      'email'                   => 'Text',
      'move_in'                 => 'Date',
      'move_out'                => 'Date',
      'bill_limit'              => 'Number',
      'room'                    => 'ForeignKey',
      'warning1'                => 'Boolean',
      'warning2'                => 'Boolean',
      'unlocked'                => 'Boolean',
      'vm_active'               => 'Boolean',
      'vm_seconds'              => 'Text',
      'mail_on_missed_call'     => 'Boolean',
      'shortened_itemized_bill' => 'Boolean',
      'account_number'          => 'Text',
      'bank_number'             => 'ForeignKey',
      'password'                => 'Text',
      'hekphone'                => 'Boolean',
      'culture'                 => 'Text',
      'groupcalls_list'         => 'ManyKey',
    );
  }
}
