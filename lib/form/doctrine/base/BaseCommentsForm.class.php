<?php

/**
 * Comments form base class.
 *
 * @method Comments getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCommentsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'resident' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Residents'), 'add_empty' => false)),
      'stamp'    => new sfWidgetFormDateTime(),
      'comment'  => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'resident' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Residents'))),
      'stamp'    => new sfValidatorDateTime(array('required' => false)),
      'comment'  => new sfValidatorString(array('max_length' => 1000)),
    ));

    $this->widgetSchema->setNameFormat('comments[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Comments';
  }

}
