<?php
class SettingsForm extends sfForm
{
  public function configure()
  {
    $this->disableLocalCSRFProtection();
    $this->setWidgets(array(
      // General settings
      'newEmail' => new sfWidgetFormInput(array(
        'label' => 'resident.settings.newEmail')),
      'newPassword' => new sfWidgetFormInputPassword(array(
        'label' => 'resident.settings.newPassword')),
      'newPasswordRepeat' => new sfWidgetFormInputPassword(array(
        'label' => 'resident.settings.newPasswordRepeat')),
      'reducedCdrs' => new sfWidgetFormInputCheckbox(array(
        'label' => 'resident.settings.reducedCdrs',
        'default' => true)),
      'sendEmailOnMissedCall' => new sfWidgetFormInputCheckbox(array(
        'label' => 'resident.settings.sendEmailOnMissedCall',
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
      'vm_saycid' => new sfWidgetFormInputCheckbox(array(
        'label' => 'resident.settings.vm_saycid',
        'default' => true)),

      // Redirect stuff
      'redirect_active' => new sfWidgetFormInputCheckbox(array(
        'label' => 'resident.settings.redirect_active',
        'default' => true)),
      'redirect_to' => new sfWidgetFormInput(array(
        'label' => 'resident.settings.redirect_to')),
      'redirect_seconds' => new sfWidgetFormInput(array(
        'label' => 'resident.settings.redirect_seconds',
        'default' => 15)),
    ));
    $this->widgetSchema->setNameFormat('settings[%s]');

    $this->setValidators(array(
      'newEmail'          => new sfValidatorEmail(array('required' => false), array('invalid' => 'resident.settings.error.emailInvalid')),
      'newPassword'       => new sfValidatorString(array('required' => false)),
      'newPasswordRepeat' => new sfValidatorString(array('required' => false)),
      'reducedCdrs'       => new sfValidatorBoolean(array('required' => false)),
      'sendEmailOnMissedCall' => new sfValidatorBoolean(array('required' => false)),

      'vm_active'         => new sfValidatorBoolean(array('required' => false)),
      'vm_seconds'        => new sfValidatorPass(), // gets validated in a post validator because if depends on vm_active
      'vm_sendEmailOnNewMessage' => new sfValidatorBoolean(array('required' => false)),
      'vm_attachMessage'         => new sfValidatorBoolean(array('required' => false)),
      'vm_saycid'         => new sfValidatorBoolean(array('required' => false)),

      'redirect_active'   => new sfValidatorBoolean(array('required' => false)),
      'redirect_to'       => new sfValidatorString(array('required' => false)),
      'redirect_seconds'  => new sfValidatorPass(), // gets validated in a post validator because if depends on redirect_active
    ));

    $this->mergePostValidator(
          new sfValidatorSchemaCompare('newPassword', '==', 'newPasswordRepeat', array(), array('invalid' => 'resident.settings.error.passwordsDoNotMatch')));
    $this->mergePostValidator(
          new sfValidatorCallback(array('callback' => array($this, 'checkVoicemailSeconds'))));
    $this->mergePostValidator(
          new sfValidatorCallback(array('callback' => array($this, 'checkRedirectSeconds'))));
    $this->mergePostValidator(
          new sfValidatorCallback(array('callback' => array($this, 'checkRedirectTo'))));
  }

  public function checkVoicemailSeconds($validator, $values) {
      if($values['vm_active']) {
        $error = false;
        if($values['vm_seconds'] > 9999) {
            $error = new sfValidatorError($validator, 'resident.settings.error.secondsTooBig');
        } elseif($values['vm_seconds'] < 0) {
            $error = new sfValidatorError($validator, 'resident.settings.error.secondsNegative');
        } elseif( ! is_numeric($values['vm_seconds']) || (int)$values['vm_seconds'] != $values['vm_seconds']) {
            $error = new sfValidatorError($validator, 'resident.settings.error.secondsNoInteger');
        }

        if($error) {
            throw new sfValidatorErrorSchema($validator, array('vm_seconds' => $error));
        }

        return $values;
      }

      return $values;
  }

  public function checkRedirectSeconds($validator, $values) {
      if($values['redirect_active']) {
        $error = false;
        if($values['redirect_seconds'] > 9999) {
            $error = new sfValidatorError($validator, 'resident.settings.error.secondsTooBig');
        } elseif($values['redirect_seconds'] < 0) {
            $error = new sfValidatorError($validator, 'resident.settings.error.secondsNegative');
        } elseif( ! is_numeric($values['redirect_seconds']) || (int)$values['redirect_seconds'] != $values['redirect_seconds']) {
            $error = new sfValidatorError($validator, 'resident.settings.error.secondsNoInteger');
        }

        if($error) {
            throw new sfValidatorErrorSchema($validator, array('redirect_seconds' => $error));
        }
      }

      return $values;
  }

  public function checkRedirectTo($validator, $values) {
      if($values['redirect_active']) {
        $error = false;
        if(strlen($values['redirect_to']) != 4 || $values['redirect_to'][0] != 1) {
            $error = new sfValidatorError($validator, 'resident.settings.error.redirectToPatternMismatch');
        } elseif($values['redirect_to'] == 1023 || $values['redirect_to'] == 147) {
            $error = new sfValidatorError($validator, 'resident.settings.error.redirectToDoorForbidden');
        }

        if($error) {
            throw new sfValidatorErrorSchema($validator, array('redirect_seconds' => $error));
        }
      }

      return $values;
  }
}