<?php
class LoginForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'roomNo'     => new sfWidgetFormInput(),
      'password'   => new sfWidgetFormInputPassword()
    ));

    $this->widgetSchema->setNameFormat('login[%s]');

    $this->widgetSchema->setLabels(array(
      'roomNo'     => 'Room Number',
      'password'   => 'Password'
    ));

    $this->setValidators(array(
      'roomNo'     => new sfValidatorInteger(array('min' => 1, 'max' => 900)),
      'password'   => new sfValidatorString()));
  }
}
