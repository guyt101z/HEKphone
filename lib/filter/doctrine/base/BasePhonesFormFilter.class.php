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
      'name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'type'        => new sfWidgetFormChoice(array('choices' => array('' => '', 'user' => 'user', 'peer' => 'peer', 'friend' => 'friend'))),
      'callerid'    => new sfWidgetFormFilterInput(),
      'secret'      => new sfWidgetFormFilterInput(),
      'host'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'defaultip'   => new sfWidgetFormFilterInput(),
      'mac'         => new sfWidgetFormFilterInput(),
      'language'    => new sfWidgetFormFilterInput(),
      'mailbox'     => new sfWidgetFormFilterInput(),
      'defaultuser' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'regexten'    => new sfWidgetFormFilterInput(),
      'regserver'   => new sfWidgetFormFilterInput(),
      'regseconds'  => new sfWidgetFormFilterInput(),
      'fromuser'    => new sfWidgetFormFilterInput(),
      'fromdomain'  => new sfWidgetFormFilterInput(),
      'ipaddr'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'port'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fullcontact' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'useragent'   => new sfWidgetFormFilterInput(),
      'lastms'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'        => new sfValidatorPass(array('required' => false)),
      'type'        => new sfValidatorChoice(array('required' => false, 'choices' => array('user' => 'user', 'peer' => 'peer', 'friend' => 'friend'))),
      'callerid'    => new sfValidatorPass(array('required' => false)),
      'secret'      => new sfValidatorPass(array('required' => false)),
      'host'        => new sfValidatorPass(array('required' => false)),
      'defaultip'   => new sfValidatorPass(array('required' => false)),
      'mac'         => new sfValidatorPass(array('required' => false)),
      'language'    => new sfValidatorPass(array('required' => false)),
      'mailbox'     => new sfValidatorPass(array('required' => false)),
      'defaultuser' => new sfValidatorPass(array('required' => false)),
      'regexten'    => new sfValidatorPass(array('required' => false)),
      'regserver'   => new sfValidatorPass(array('required' => false)),
      'regseconds'  => new sfValidatorPass(array('required' => false)),
      'fromuser'    => new sfValidatorPass(array('required' => false)),
      'fromdomain'  => new sfValidatorPass(array('required' => false)),
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
      'name'        => 'Text',
      'type'        => 'Enum',
      'callerid'    => 'Text',
      'secret'      => 'Text',
      'host'        => 'Text',
      'defaultip'   => 'Text',
      'mac'         => 'Text',
      'language'    => 'Text',
      'mailbox'     => 'Text',
      'defaultuser' => 'Text',
      'regexten'    => 'Text',
      'regserver'   => 'Text',
      'regseconds'  => 'Text',
      'fromuser'    => 'Text',
      'fromdomain'  => 'Text',
      'ipaddr'      => 'Text',
      'port'        => 'Text',
      'fullcontact' => 'Text',
      'useragent'   => 'Text',
      'lastms'      => 'Text',
    );
  }
}
