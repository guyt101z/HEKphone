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
      'id'                     => new sfWidgetFormInputHidden(),
      'technology'             => new sfWidgetFormChoice(array('choices' => array('SIP' => 'SIP', 'DAHDI/g1' => 'DAHDI/g1', 'DAHDI/g3' => 'DAHDI/g3'))),
      'type'                   => new sfWidgetFormChoice(array('choices' => array('user' => 'user', 'peer' => 'peer', 'friend' => 'friend'))),
      'host'                   => new sfWidgetFormInputText(),
      'mac'                    => new sfWidgetFormInputText(),
      'regserver'              => new sfWidgetFormInputText(),
      'regseconds'             => new sfWidgetFormInputText(),
      'ipaddr'                 => new sfWidgetFormInputText(),
      'port'                   => new sfWidgetFormInputText(),
      'fullcontact'            => new sfWidgetFormInputText(),
      'useragent'              => new sfWidgetFormInputText(),
      'lastms'                 => new sfWidgetFormInputText(),
      'web_interface_password' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'technology'             => new sfValidatorChoice(array('choices' => array(0 => 'SIP', 1 => 'DAHDI/g1', 2 => 'DAHDI/g3'), 'required' => false)),
      'type'                   => new sfValidatorChoice(array('choices' => array(0 => 'user', 1 => 'peer', 2 => 'friend'), 'required' => false)),
      'host'                   => new sfValidatorString(array('max_length' => 31, 'required' => false)),
      'mac'                    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'regserver'              => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'regseconds'             => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'ipaddr'                 => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'port'                   => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'fullcontact'            => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'useragent'              => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'lastms'                 => new sfValidatorString(array('max_length' => 11, 'required' => false)),
      'web_interface_password' => new sfValidatorString(array('max_length' => 8, 'required' => false)),
    ));

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
