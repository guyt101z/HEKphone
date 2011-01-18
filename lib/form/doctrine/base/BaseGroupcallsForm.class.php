<?php

/**
 * Groupcalls form base class.
 *
 * @method Groupcalls getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseGroupcallsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'extension'      => new sfWidgetFormTextarea(),
      'name'           => new sfWidgetFormTextarea(),
      'residents_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Residents')),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'extension'      => new sfValidatorString(array('required' => false)),
      'name'           => new sfValidatorString(array('required' => false)),
      'residents_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Residents', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Groupcalls', 'column' => array('extension')))
    );

    $this->widgetSchema->setNameFormat('groupcalls[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Groupcalls';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['residents_list']))
    {
      $this->setDefault('residents_list', $this->object->Residents->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveResidentsList($con);

    parent::doSave($con);
  }

  public function saveResidentsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['residents_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Residents->getPrimaryKeys();
    $values = $this->getValue('residents_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Residents', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Residents', array_values($link));
    }
  }

}
