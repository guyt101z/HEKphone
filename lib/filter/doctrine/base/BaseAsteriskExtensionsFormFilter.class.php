<?php

/**
 * AsteriskExtensions filter form base class.
 *
 * @package    hekphone
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAsteriskExtensionsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'context'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'exten'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'priority' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'app'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'appdata'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'context'  => new sfValidatorPass(array('required' => false)),
      'exten'    => new sfValidatorPass(array('required' => false)),
      'priority' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'app'      => new sfValidatorPass(array('required' => false)),
      'appdata'  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('asterisk_extensions_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AsteriskExtensions';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'context'  => 'Text',
      'exten'    => 'Text',
      'priority' => 'Number',
      'app'      => 'Text',
      'appdata'  => 'Text',
    );
  }
}
