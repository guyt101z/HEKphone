<?php use_javascript('jquery.js') ?>
<?php use_javascript('jquery-settings_hide_show_form_parts.js') ?>
<div class="formContainer">
<form action="<?php echo url_for('settings/update') ?>" method="POST">
  <fieldset id="general">
    <legend><label><?php echo __('resident.settings.general') ?></label></legend>
    <p class="help"><?php echo __('resident.settings.general_help')?></p>
    <div>
      <?php echo $form['newEmail']->renderLabel() ?>
      <?php echo $form['newEmail'] . "\n" ?>
      <?php echo $form['newEmail']->renderError() ?>
    </div>
    <div>
     <?php echo $form['newPassword']->renderLabel() ?>
      <?php echo $form['newPassword'] . "\n" ?>
      <?php echo $form['newPassword']->renderError() ?>
    </div>
    <div>
      <?php echo $form['newPasswordRepeat']->renderLabel() ?>
      <?php echo $form['newPasswordRepeat'] . "\n" ?>
      <?php echo $form['newPasswordRepeat']->renderError() ?>
    </div>
    <div class="checkbox">
      <?php echo $form['reducedCdrs'] . "\n" ?>
      <?php echo $form['reducedCdrs']->renderLabel() ?>
      <?php echo $form['reducedCdrs']->renderError() ?>
    </div>
    <div class="checkbox">
      <?php echo $form['sendEmailOnMissedCall'] . "\n" ?>
     <?php echo $form['sendEmailOnMissedCall']->renderLabel() ?>
      <?php echo $form['sendEmailOnMissedCall']->renderError() ?>
    </div>
  </fieldset>


  <fieldset id="voicemail">
    <legend>
      <?php echo $form['vm_active'] . "\n" ?>
      <?php echo $form['vm_active']->renderLabel() ?>
    </legend>
    <p class="help"><?php echo __('resident.settings.vm_help')?></p>
    <div class="voicemailField">
      <?php echo $form['vm_seconds']->renderLabel() ?>
      <?php echo $form['vm_seconds'] . "\n" ?>
      <?php echo $form['vm_seconds']->renderError() ?>
    </div>
    <div class="checkbox voicemailField">
      <?php echo $form['vm_sendEmailOnNewMessage'] . "\n" ?>
      <?php echo $form['vm_sendEmailOnNewMessage']->renderLabel() ?>
      <?php echo $form['vm_sendEmailOnNewMessage']->renderError() ?>
    </div>
    <div class="checkbox voicemailField">
      <?php echo $form['vm_attachMessage'] . "\n" ?>
      <?php echo $form['vm_attachMessage']->renderLabel() ?>
      <?php echo $form['vm_attachMessage']->renderError() ?>
    </div>
  </fieldset>

  <fieldset id="redirect">
    <legend>
      <?php echo $form['redirect_active'] . "\n" ?>
      <?php echo $form['redirect_active']->renderLabel() ?>
    </legend>
    <p class="help"><?php echo __('resident.settings.redirect_help')?></p>
    <div class="redirectField">
      <?php echo $form['redirect_to']->renderLabel() ?>
      <?php echo $form['redirect_to'] . "\n" ?>
      <?php echo $form['redirect_to']->renderError() ?>
    </div>
    <div class="redirectField">
      <?php echo $form['redirect_seconds']->renderLabel() ?>
      <?php echo $form['redirect_seconds'] . "\n" ?>
      <?php echo $form['redirect_seconds']->renderError() ?>
    </div>
  </fieldset>

  <input type="submit" value="<?php echo __('resident.settings.submit') ?>" />

  </form>
</div>