<?php

/**
 * Prefixes form base class.
 *
 * @method Prefixes getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePrefixesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'     => new sfWidgetFormInputHidden(),
      'prefix' => new sfWidgetFormInputText(),
      'name'   => new sfWidgetFormInputText(),
      'region' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Regions'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'prefix' => new sfValidatorString(array('max_length' => 20)),
      'name'   => new sfValidatorString(array('max_length' => 80)),
      'region' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Regions'))),
    ));

    $this->widgetSchema->setNameFormat('prefixes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Prefixes';
  }

}
