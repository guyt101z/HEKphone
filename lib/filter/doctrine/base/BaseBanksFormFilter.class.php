<?php

/**
 * Banks filter form base class.
 *
 * @package    hekphone
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseBanksFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'zip'         => new sfWidgetFormFilterInput(),
      'locality'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'        => new sfValidatorPass(array('required' => false)),
      'zip'         => new sfValidatorPass(array('required' => false)),
      'locality'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('banks_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Banks';
  }

  public function getFields()
  {
    return array(
      'bank_number' => 'Text',
      'name'        => 'Text',
      'zip'         => 'Text',
      'locality'    => 'Text',
    );
  }
}
