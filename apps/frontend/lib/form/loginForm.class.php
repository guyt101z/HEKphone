<?php
class LoginForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'roomNo' => new sfWidgetFormInput(),
      'password' => new sfWidgetFormInputPassword()
    ));

    $this->widgetSchema->setNameFormat('login[%s]');

    $this->setValidator('roomNo', new sfValidatorInteger(array('min' => 1, 'max' => 900)));
    $this->setValidator('password', new sfValidatorString());
  }
}
