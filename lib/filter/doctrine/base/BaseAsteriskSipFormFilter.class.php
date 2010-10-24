<?php

/**
 * AsteriskSip filter form base class.
 *
 * @package    hekphone
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAsteriskSipFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'accountcode' => new sfWidgetFormFilterInput(),
      'callerid'    => new sfWidgetFormFilterInput(),
      'canreinvite' => new sfWidgetFormFilterInput(),
      'context'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'host'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'port'        => new sfWidgetFormFilterInput(),
      'mailbox'     => new sfWidgetFormFilterInput(),
      'md5secret'   => new sfWidgetFormFilterInput(),
      'nat'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'permit'      => new sfWidgetFormFilterInput(),
      'deny'        => new sfWidgetFormFilterInput(),
      'mask'        => new sfWidgetFormFilterInput(),
      'qualify'     => new sfWidgetFormFilterInput(),
      'secret'      => new sfWidgetFormFilterInput(),
      'type'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'username'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'defaultuser' => new sfWidgetFormFilterInput(),
      'useragent'   => new sfWidgetFormFilterInput(),
      'fromuser'    => new sfWidgetFormFilterInput(),
      'fromdomain'  => new sfWidgetFormFilterInput(),
      'disallow'    => new sfWidgetFormFilterInput(),
      'allow'       => new sfWidgetFormFilterInput(),
      'ipaddr'      => new sfWidgetFormFilterInput(),
      'mac'         => new sfWidgetFormFilterInput(),
      'fullcontact' => new sfWidgetFormFilterInput(),
      'regexten'    => new sfWidgetFormFilterInput(),
      'regserver'   => new sfWidgetFormFilterInput(),
      'regseconds'  => new sfWidgetFormFilterInput(),
      'lastms'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'        => new sfValidatorPass(array('required' => false)),
      'accountcode' => new sfValidatorPass(array('required' => false)),
      'callerid'    => new sfValidatorPass(array('required' => false)),
      'canreinvite' => new sfValidatorPass(array('required' => false)),
      'context'     => new sfValidatorPass(array('required' => false)),
      'host'        => new sfValidatorPass(array('required' => false)),
      'port'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mailbox'     => new sfValidatorPass(array('required' => false)),
      'md5secret'   => new sfValidatorPass(array('required' => false)),
      'nat'         => new sfValidatorPass(array('required' => false)),
      'permit'      => new sfValidatorPass(array('required' => false)),
      'deny'        => new sfValidatorPass(array('required' => false)),
      'mask'        => new sfValidatorPass(array('required' => false)),
      'qualify'     => new sfValidatorPass(array('required' => false)),
      'secret'      => new sfValidatorPass(array('required' => false)),
      'type'        => new sfValidatorPass(array('required' => false)),
      'username'    => new sfValidatorPass(array('required' => false)),
      'defaultuser' => new sfValidatorPass(array('required' => false)),
      'useragent'   => new sfValidatorPass(array('required' => false)),
      'fromuser'    => new sfValidatorPass(array('required' => false)),
      'fromdomain'  => new sfValidatorPass(array('required' => false)),
      'disallow'    => new sfValidatorPass(array('required' => false)),
      'allow'       => new sfValidatorPass(array('required' => false)),
      'ipaddr'      => new sfValidatorPass(array('required' => false)),
      'mac'         => new sfValidatorPass(array('required' => false)),
      'fullcontact' => new sfValidatorPass(array('required' => false)),
      'regexten'    => new sfValidatorPass(array('required' => false)),
      'regserver'   => new sfValidatorPass(array('required' => false)),
      'regseconds'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lastms'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('asterisk_sip_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AsteriskSip';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'name'        => 'Text',
      'accountcode' => 'Text',
      'callerid'    => 'Text',
      'canreinvite' => 'Text',
      'context'     => 'Text',
      'host'        => 'Text',
      'port'        => 'Number',
      'mailbox'     => 'Text',
      'md5secret'   => 'Text',
      'nat'         => 'Text',
      'permit'      => 'Text',
      'deny'        => 'Text',
      'mask'        => 'Text',
      'qualify'     => 'Text',
      'secret'      => 'Text',
      'type'        => 'Text',
      'username'    => 'Text',
      'defaultuser' => 'Text',
      'useragent'   => 'Text',
      'fromuser'    => 'Text',
      'fromdomain'  => 'Text',
      'disallow'    => 'Text',
      'allow'       => 'Text',
      'ipaddr'      => 'Text',
      'mac'         => 'Text',
      'fullcontact' => 'Text',
      'regexten'    => 'Text',
      'regserver'   => 'Text',
      'regseconds'  => 'Number',
      'lastms'      => 'Number',
    );
  }
}
