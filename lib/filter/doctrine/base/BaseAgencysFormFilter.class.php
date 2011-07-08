<?php

/**
 * Agencys filter form base class.
 *
 * @package    hekphone
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAgencysFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'postcode'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'city'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'shortterm' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'bank'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Banks'), 'add_empty' => true)),
      'pan'       => new sfWidgetFormFilterInput(),
      'bic'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'      => new sfValidatorPass(array('required' => false)),
      'postcode'  => new sfValidatorPass(array('required' => false)),
      'city'      => new sfValidatorPass(array('required' => false)),
      'shortterm' => new sfValidatorPass(array('required' => false)),
      'bank'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Banks'), 'column' => 'id')),
      'pan'       => new sfValidatorPass(array('required' => false)),
      'bic'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('agencys_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Agencys';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'name'      => 'Text',
      'postcode'  => 'Text',
      'city'      => 'Text',
      'shortterm' => 'Text',
      'bank'      => 'ForeignKey',
      'pan'       => 'Text',
      'bic'       => 'Text',
    );
  }
}
