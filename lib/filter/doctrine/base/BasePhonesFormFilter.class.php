<?php

/**
 * Phones filter form base class.
 *
 * @package    hekphone
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePhonesFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'technology'  => new sfWidgetFormChoice(array('choices' => array('' => '', 'SIP' => 'SIP', 'DAHDI/g1' => 'DAHDI/g1', 'DAHDI/g3' => 'DAHDI/g3'))),
      'type'        => new sfWidgetFormChoice(array('choices' => array('' => '', 'user' => 'user', 'peer' => 'peer', 'friend' => 'friend'))),
      'host'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mac'         => new sfWidgetFormFilterInput(),
      'regserver'   => new sfWidgetFormFilterInput(),
      'regseconds'  => new sfWidgetFormFilterInput(),
      'ipaddr'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'port'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fullcontact' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'useragent'   => new sfWidgetFormFilterInput(),
      'lastms'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'technology'  => new sfValidatorChoice(array('required' => false, 'choices' => array('SIP' => 'SIP', 'DAHDI/g1' => 'DAHDI/g1', 'DAHDI/g3' => 'DAHDI/g3'))),
      'type'        => new sfValidatorChoice(array('required' => false, 'choices' => array('user' => 'user', 'peer' => 'peer', 'friend' => 'friend'))),
      'host'        => new sfValidatorPass(array('required' => false)),
      'mac'         => new sfValidatorPass(array('required' => false)),
      'regserver'   => new sfValidatorPass(array('required' => false)),
      'regseconds'  => new sfValidatorPass(array('required' => false)),
      'ipaddr'      => new sfValidatorPass(array('required' => false)),
      'port'        => new sfValidatorPass(array('required' => false)),
      'fullcontact' => new sfValidatorPass(array('required' => false)),
      'useragent'   => new sfValidatorPass(array('required' => false)),
      'lastms'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('phones_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Phones';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'technology'  => 'Enum',
      'type'        => 'Enum',
      'host'        => 'Text',
      'mac'         => 'Text',
      'regserver'   => 'Text',
      'regseconds'  => 'Text',
      'ipaddr'      => 'Text',
      'port'        => 'Text',
      'fullcontact' => 'Text',
      'useragent'   => 'Text',
      'lastms'      => 'Text',
    );
  }
}
