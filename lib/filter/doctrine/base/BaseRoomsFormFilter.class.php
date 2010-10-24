<?php

/**
 * Rooms filter form base class.
 *
 * @package    hekphone
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseRoomsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'room_no' => new sfWidgetFormFilterInput(),
      'comment' => new sfWidgetFormFilterInput(),
      'phone'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Phones'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'room_no' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'comment' => new sfValidatorPass(array('required' => false)),
      'phone'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Phones'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('rooms_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Rooms';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'room_no' => 'Number',
      'comment' => 'Text',
      'phone'   => 'ForeignKey',
    );
  }
}
