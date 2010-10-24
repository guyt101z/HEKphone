<?php

/**
 * Prefixes filter form base class.
 *
 * @package    hekphone
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePrefixesFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'prefix' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'region' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Regions'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'prefix' => new sfValidatorPass(array('required' => false)),
      'name'   => new sfValidatorPass(array('required' => false)),
      'region' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Regions'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('prefixes_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Prefixes';
  }

  public function getFields()
  {
    return array(
      'id'     => 'Number',
      'prefix' => 'Text',
      'name'   => 'Text',
      'region' => 'ForeignKey',
    );
  }
}
