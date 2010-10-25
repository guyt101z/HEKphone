<?php

/**
 * RatesRegions filter form base class.
 *
 * @package    hekphone
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseRatesRegionsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'rate'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Rates'), 'add_empty' => true)),
      'region' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Regions'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'rate'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Rates'), 'column' => 'id')),
      'region' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Regions'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('rates_regions_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RatesRegions';
  }

  public function getFields()
  {
    return array(
      'id'     => 'Number',
      'rate'   => 'ForeignKey',
      'region' => 'ForeignKey',
    );
  }
}
