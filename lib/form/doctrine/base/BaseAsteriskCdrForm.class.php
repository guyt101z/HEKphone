<?php

/**
 * AsteriskCdr form base class.
 *
 * @method AsteriskCdr getObject() Returns the current form's model object
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAsteriskCdrForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'calldate'    => new sfWidgetFormDateTime(),
      'clid'        => new sfWidgetFormTextarea(),
      'src'         => new sfWidgetFormTextarea(),
      'dst'         => new sfWidgetFormTextarea(),
      'dcontext'    => new sfWidgetFormTextarea(),
      'channel'     => new sfWidgetFormTextarea(),
      'dstchannel'  => new sfWidgetFormTextarea(),
      'lastapp'     => new sfWidgetFormTextarea(),
      'lastdata'    => new sfWidgetFormTextarea(),
      'duration'    => new sfWidgetFormInputText(),
      'billsec'     => new sfWidgetFormInputText(),
      'disposition' => new sfWidgetFormTextarea(),
      'amaflags'    => new sfWidgetFormInputText(),
      'accountcode' => new sfWidgetFormTextarea(),
      'uniqueid'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Calls'), 'add_empty' => false)),
      'userfield'   => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'calldate'    => new sfValidatorDateTime(array('required' => false)),
      'clid'        => new sfValidatorString(),
      'src'         => new sfValidatorString(),
      'dst'         => new sfValidatorString(),
      'dcontext'    => new sfValidatorString(),
      'channel'     => new sfValidatorString(),
      'dstchannel'  => new sfValidatorString(),
      'lastapp'     => new sfValidatorString(),
      'lastdata'    => new sfValidatorString(),
      'duration'    => new sfValidatorInteger(array('required' => false)),
      'billsec'     => new sfValidatorInteger(array('required' => false)),
      'disposition' => new sfValidatorString(),
      'amaflags'    => new sfValidatorInteger(array('required' => false)),
      'accountcode' => new sfValidatorString(),
      'uniqueid'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Calls'))),
      'userfield'   => new sfValidatorString(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'AsteriskCdr', 'column' => array('uniqueid')))
    );

    $this->widgetSchema->setNameFormat('asterisk_cdr[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AsteriskCdr';
  }

}
