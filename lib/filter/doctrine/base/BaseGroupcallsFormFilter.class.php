<?php

/**
 * Groupcalls filter form base class.
 *
 * @package    hekphone
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGroupcallsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'extension'      => new sfWidgetFormFilterInput(),
      'name'           => new sfWidgetFormFilterInput(),
      'mode'           => new sfWidgetFormChoice(array('choices' => array('' => '', 'parallel' => 'parallel', 'serial' => 'serial'))),
      'residents_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Residents')),
    ));

    $this->setValidators(array(
      'extension'      => new sfValidatorPass(array('required' => false)),
      'name'           => new sfValidatorPass(array('required' => false)),
      'mode'           => new sfValidatorChoice(array('required' => false, 'choices' => array('parallel' => 'parallel', 'serial' => 'serial'))),
      'residents_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Residents', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('groupcalls_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addResidentsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('ResidentsGroupcalls.resident_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Groupcalls';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'extension'      => 'Text',
      'name'           => 'Text',
      'mode'           => 'Enum',
      'residents_list' => 'ManyKey',
    );
  }
}
