<?php

/**
 * RatesRegions form base class.
 *
 * @method RatesRegions getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRatesRegionsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'     => new sfWidgetFormInputHidden(),
      'rate'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Rates'), 'add_empty' => false)),
      'region' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Regions'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'rate'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Rates'))),
      'region' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Regions'), 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'RatesRegions', 'column' => array('rate'))),
        new sfValidatorDoctrineUnique(array('model' => 'RatesRegions', 'column' => array('region'))),
      ))
    );

    $this->widgetSchema->setNameFormat('rates_regions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RatesRegions';
  }

}
