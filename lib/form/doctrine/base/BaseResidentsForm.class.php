<?php

/**
 * Residents form base class.
 *
 * @method Residents getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseResidentsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'last_name'               => new sfWidgetFormInputText(),
      'first_name'              => new sfWidgetFormInputText(),
      'email'                   => new sfWidgetFormInputText(),
      'move_in'                 => new sfWidgetFormDate(),
      'move_out'                => new sfWidgetFormDate(),
      'bill_limit'              => new sfWidgetFormInputText(),
      'room'                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Rooms'), 'add_empty' => true)),
      'warning1'                => new sfWidgetFormInputCheckbox(),
      'warning2'                => new sfWidgetFormInputCheckbox(),
      'unlocked'                => new sfWidgetFormInputCheckbox(),
      'vm_active'               => new sfWidgetFormInputCheckbox(),
      'vm_seconds'              => new sfWidgetFormInputText(),
      'mail_on_missed_call'     => new sfWidgetFormInputCheckbox(),
      'shortened_itemized_bill' => new sfWidgetFormInputCheckbox(),
      'redirect_active'         => new sfWidgetFormInputCheckbox(),
      'redirect_to'             => new sfWidgetFormInputText(),
      'redirect_seconds'        => new sfWidgetFormInputText(),
      'account_number'          => new sfWidgetFormInputText(),
      'bank_number'             => new sfWidgetFormInputText(),
      'password'                => new sfWidgetFormInputText(),
      'hekphone'                => new sfWidgetFormInputCheckbox(),
      'culture'                 => new sfWidgetFormInputText(),
      'groupcalls_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Groupcalls')),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'last_name'               => new sfValidatorString(array('max_length' => 50)),
      'first_name'              => new sfValidatorString(array('max_length' => 50)),
      'email'                   => new sfValidatorEmail(array('max_length' => 255, 'required' => false)),
      'move_in'                 => new sfValidatorDate(),
      'move_out'                => new sfValidatorDate(array('required' => false)),
      'bill_limit'              => new sfValidatorInteger(array('required' => false)),
      'room'                    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Rooms'), 'required' => false)),
      'warning1'                => new sfValidatorBoolean(array('required' => false)),
      'warning2'                => new sfValidatorBoolean(array('required' => false)),
      'unlocked'                => new sfValidatorBoolean(array('required' => false)),
      'vm_active'               => new sfValidatorBoolean(array('required' => false)),
      'vm_seconds'              => new sfValidatorPass(array('required' => false)),
      'mail_on_missed_call'     => new sfValidatorBoolean(array('required' => false)),
      'shortened_itemized_bill' => new sfValidatorBoolean(array('required' => false)),
      'redirect_active'         => new sfValidatorBoolean(array('required' => false)),
      'redirect_to'             => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'redirect_seconds'        => new sfValidatorPass(array('required' => false)),
      'account_number'          => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'bank_number'             => new sfValidatorInteger(array('required' => false)),
      'password'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'hekphone'                => new sfValidatorBoolean(array('required' => false)),
      'culture'                 => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'groupcalls_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Groupcalls', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Residents', 'column' => array('room')))
    );

    $this->widgetSchema->setNameFormat('residents[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Residents';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['groupcalls_list']))
    {
      $this->setDefault('groupcalls_list', $this->object->Groupcalls->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveGroupcallsList($con);

    parent::doSave($con);
  }

  public function saveGroupcallsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['groupcalls_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Groupcalls->getPrimaryKeys();
    $values = $this->getValue('groupcalls_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Groupcalls', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Groupcalls', array_values($link));
    }
  }

}
