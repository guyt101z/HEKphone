<?php
class SettingsForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      // General settings
      'newEmail' => new sfWidgetFormInput(array(
        'label' => 'resident.settings.newEmail')),
      'newEmailRepeat' => new sfWidgetFormInput(array(
        'label' => 'resident.settings.newEmailRepeat')),
      'oldPassword' => new sfWidgetFormInputPassword(array(
        'label' => 'resident.settings.oldPassword')),
      'newPassword' => new sfWidgetFormInputPassword(array(
        'label' => 'resident.settings.newPassword')),
      'newPasswordRepeat' => new sfWidgetFormInputPassword(array(
        'label' => 'resident.settings.newPasswordRepeat')),
      'newPin' => new sfWidgetFormInput(array(
        'label' => 'resident.settings.newPin')),
      'reducedCdrs' => new sfWidgetFormInputCheckbox(array(
        'label' => 'resident.settings.reducedCdrs',
        'default' => true)),
      // Voicemail stuff
      'vm_active' => new sfWidgetFormInputCheckbox(array(
        'label' => 'resident.settings.vm_active',
        'default' => true)),
      'vm_seconds' => new sfWidgetFormInput(array(
        'label' => 'resident.settings.vm_seconds',
        'default' => 15)),
      'vm_sendEmailOnNewMessage' => new sfWidgetFormInputCheckbox(array(
        'label' => 'resident.settings.vm_sendEmailOnNewMessage',
        'default' => true)),
      'vm_attachMessage' => new sfWidgetFormInputCheckbox(array(
        'label' => 'resident.settings.vm_attachMessage',
        'default' => true)),
      'vm_sendEmailOnMissedCall' => new sfWidgetFormInputCheckbox(array(
        'label' => 'resident.settings.vm_sendEmailOnMissedCall',
        'default' => true)),
    ));
    $this->widgetSchema->setNameFormat('settings[%s]');

    $this->setValidators(array(
      'newEmail'          => new sfValidatorEmail(array('required' => false), array('invalid' => 'resident.settings.error.emailInvalid')),
      'newEmailRepeat'    => new sfValidatorEmail(array('required' => false), array('invalid' => 'resident.settings.error.emailInvalid')),
      'oldPassword'       => new sfValidatorString(array('required' => false)),
      'newPassword'       => new sfValidatorString(array('required' => false)),
      'newPasswordRepeat' => new sfValidatorString(array('required' => false)),
      'newPin'            => new sfValidatorInteger(array('required' => false, 'min' => 0, 'max' => 99999999), array(
        'invalid' => 'resident.settings.error.secondsNoInteger',
        'min'     => 'resident.settings.error.secondsNegative',
        'max'     => 'resident.settings.error.secondsTooBig',
        ), array('invalid' => 'resident.settings.error.pinNoInteger')),
      'reducedCdrs'       => new sfValidatorBoolean(array('required' => false)),
      'vm_active'         => new sfValidatorBoolean(array('required' => false)),
      'vm_seconds'        => new sfValidatorInteger(array('required' => true, 'min' => 0, 'max' => 1000), array(
        'invalid' => 'resident.settings.error.secondsNoInteger',
        'min'     => 'resident.settings.error.secondsNegative',
        'max'     => 'resident.settings.error.secondsTooBig',
      )),
      'vm_sendEmailOnNewMessage' => new sfValidatorBoolean(array('required' => false)),
      'vm_attachMessage'         => new sfValidatorBoolean(array('required' => false)),
      'vm_sendEmailOnMissedCall' => new sfValidatorBoolean(array('required' => false))
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        // check wheter the passwords match
        new sfValidatorSchemaCompare('newPassword', '==', 'newPasswordRepeat', array(), array('invalid' => 'resident.settings.error.passwordsDoNotMatch')),

        // check wheter the emails match
        new sfValidatorSchemaCompare('newEmail', '==', 'newEmailRepeat', array(), array('invalid' => 'resident.settings.error.emailsDoNotMatch')),
    )));
  }

}