<?php

/**
 * Phones form base class.
 *
 * @method Phones getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePhonesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormTextarea(),
      'accountcode' => new sfWidgetFormTextarea(),
      'callerid'    => new sfWidgetFormTextarea(),
      'canreinvite' => new sfWidgetFormTextarea(),
      'host'        => new sfWidgetFormTextarea(),
      'port'        => new sfWidgetFormInputText(),
      'mailbox'     => new sfWidgetFormTextarea(),
      'md5secret'   => new sfWidgetFormTextarea(),
      'nat'         => new sfWidgetFormTextarea(),
      'permit'      => new sfWidgetFormTextarea(),
      'deny'        => new sfWidgetFormTextarea(),
      'mask'        => new sfWidgetFormTextarea(),
      'qualify'     => new sfWidgetFormTextarea(),
      'secret'      => new sfWidgetFormTextarea(),
      'type'        => new sfWidgetFormTextarea(),
      'username'    => new sfWidgetFormTextarea(),
      'defaultuser' => new sfWidgetFormTextarea(),
      'useragent'   => new sfWidgetFormTextarea(),
      'fromuser'    => new sfWidgetFormTextarea(),
      'fromdomain'  => new sfWidgetFormTextarea(),
      'disallow'    => new sfWidgetFormTextarea(),
      'allow'       => new sfWidgetFormTextarea(),
      'ipaddr'      => new sfWidgetFormTextarea(),
      'mac'         => new sfWidgetFormTextarea(),
      'fullcontact' => new sfWidgetFormTextarea(),
      'regexten'    => new sfWidgetFormTextarea(),
      'regserver'   => new sfWidgetFormTextarea(),
      'regseconds'  => new sfWidgetFormInputText(),
      'lastms'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'        => new sfValidatorString(),
      'accountcode' => new sfValidatorString(array('required' => false)),
      'callerid'    => new sfValidatorString(array('required' => false)),
      'canreinvite' => new sfValidatorString(array('required' => false)),
      'host'        => new sfValidatorString(),
      'port'        => new sfValidatorInteger(array('required' => false)),
      'mailbox'     => new sfValidatorString(array('required' => false)),
      'md5secret'   => new sfValidatorString(array('required' => false)),
      'nat'         => new sfValidatorString(array('required' => false)),
      'permit'      => new sfValidatorString(array('required' => false)),
      'deny'        => new sfValidatorString(array('required' => false)),
      'mask'        => new sfValidatorString(array('required' => false)),
      'qualify'     => new sfValidatorString(array('required' => false)),
      'secret'      => new sfValidatorString(array('required' => false)),
      'type'        => new sfValidatorString(array('required' => false)),
      'username'    => new sfValidatorString(),
      'defaultuser' => new sfValidatorString(array('required' => false)),
      'useragent'   => new sfValidatorString(array('required' => false)),
      'fromuser'    => new sfValidatorString(array('required' => false)),
      'fromdomain'  => new sfValidatorString(array('required' => false)),
      'disallow'    => new sfValidatorString(array('required' => false)),
      'allow'       => new sfValidatorString(array('required' => false)),
      'ipaddr'      => new sfValidatorString(array('required' => false)),
      'mac'         => new sfValidatorString(array('required' => false)),
      'fullcontact' => new sfValidatorString(array('required' => false)),
      'regexten'    => new sfValidatorString(array('required' => false)),
      'regserver'   => new sfValidatorString(array('required' => false)),
      'regseconds'  => new sfValidatorInteger(array('required' => false)),
      'lastms'      => new sfValidatorInteger(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'Phones', 'column' => array('name'))),
        new sfValidatorDoctrineUnique(array('model' => 'Phones', 'column' => array('mac'))),
      ))
    );

    $this->widgetSchema->setNameFormat('phones[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Phones';
  }

}
