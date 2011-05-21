<?php use_javascript('jquery.js') ?>
<?php use_javascript('jquery-settings_hide_show_form_parts.js') ?>

<form action="<?php echo url_for('settings/update') ?>" method="POST">
  <fieldset id="general">
    <legend><?php echo __('resident.settings.general') ?></legend>
    <p class="help"><?php echo __('resident.settings.general_help')?></p>
    <div>
      <span><?php echo $form['newEmail']->renderLabel() ?></span>
      <?php echo $form['newEmail'] . "\n" ?>
      <span class="error"><?php echo $form['newEmail']->renderError() ?></span>
    </div>
    <div>
      <span><?php echo $form['newPassword']->renderLabel() ?></span>
      <?php echo $form['newPassword'] . "\n" ?>
      <span class="error"><?php echo $form['newPassword']->renderError() ?></span>
    </div>
    <div>
      <span><?php echo $form['newPasswordRepeat']->renderLabel() ?></span>
      <?php echo $form['newPasswordRepeat'] . "\n" ?>
      <span class="error"><?php echo $form['newPasswordRepeat']->renderError() ?></span>
    </div>
    <div>
      <span><?php echo $form['reducedCdrs']->renderLabel() ?></span>
      <?php echo $form['reducedCdrs'] . "\n" ?>
      <span class="error"><?php echo $form['reducedCdrs']->renderError() ?></span>
    </div>
    <div>
      <span><?php echo $form['sendEmailOnMissedCall']->renderLabel() ?></span>
      <?php echo $form['sendEmailOnMissedCall'] . "\n" ?>
      <span class="error"><?php echo $form['sendEmailOnMissedCall']->renderError() ?></span>
    </div>
  </fieldset>


  <fieldset id="voicemail">
    <legend>
      <?php echo $form['vm_active'] . "\n" ?>
      <span><?php echo $form['vm_active']->renderLabel() ?></span>
    </legend>
    <p class="help"><?php echo __('resident.settings.vm_help')?></p>
    <div class="voicemailField">
      <span><?php echo $form['vm_seconds']->renderLabel() ?></span>
      <?php echo $form['vm_seconds'] . "\n" ?>
      <span class="error"><?php echo $form['vm_seconds']->renderError() ?></span>
    </div>
    <div class="voicemailField">
      <span><?php echo $form['vm_sendEmailOnNewMessage']->renderLabel() ?></span>
      <?php echo $form['vm_sendEmailOnNewMessage'] . "\n" ?>
      <span class="error"><?php echo $form['vm_sendEmailOnNewMessage']->renderError() ?></span>
    </div>
    <div class="voicemailField">
      <span><?php echo $form['vm_attachMessage']->renderLabel() ?></span>
      <?php echo $form['vm_attachMessage'] . "\n" ?>
      <span class="error"><?php echo $form['vm_attachMessage']->renderError() ?></span>
    </div>
  </fieldset>

  <fieldset id="redirect">
    <legend>
      <?php echo $form['redirect_active'] . "\n" ?>
      <span><?php echo $form['redirect_active']->renderLabel() ?></span>
    </legend>
    <p class="help"><?php echo __('resident.settings.redirect_help')?></p>
    <div class="redirectField">
      <span><?php echo $form['redirect_to']->renderLabel() ?></span>
      <?php echo $form['redirect_to'] . "\n" ?>
      <span class="error"><?php echo $form['redirect_to']->renderError() ?></span>
    </div>
    <div class="redirectField">
      <span><?php echo $form['redirect_seconds']->renderLabel() ?></span>
      <?php echo $form['redirect_seconds'] . "\n" ?>
      <span class="error"><?php echo $form['redirect_seconds']->renderError() ?></span>
    </div>
  </fieldset>

  <input type="submit" value="<?php echo __('resident.settings.submit') ?>" />

  </form>