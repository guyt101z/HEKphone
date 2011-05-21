<?php use_javascript('jquery.js') ?>
<?php use_javascript('jquery-settings_hide_show_form_parts.js') ?>

<form action="<?php echo url_for('settings/update') ?>" method="POST">
  <fieldset id="general">
    <legend><?php echo __('resident.settings.general') ?></legend>
    <p class="help"><?php echo __('resident.settings.general_help')?></p>
    <div>
      <span><?php echo $form['newEmail']->renderLabel() ?></span>
      <?php echo $form['newEmail'] . "\n" ?>
      <?php echo $form['newEmail']->renderError() ?>
    </div>
    <div>
      <span><?php echo $form['newPassword']->renderLabel() ?></span>
      <?php echo $form['newPassword'] . "\n" ?>
      <?php echo $form['newPassword']->renderError() ?>
    </div>
    <div>
      <span><?php echo $form['newPasswordRepeat']->renderLabel() ?></span>
      <?php echo $form['newPasswordRepeat'] . "\n" ?>
      <?php echo $form['newPasswordRepeat']->renderError() ?>
    </div>
    <div class="checkbox">
      <?php echo $form['reducedCdrs'] . "\n" ?>
      <span><?php echo $form['reducedCdrs']->renderLabel() ?></span>
      <?php echo $form['reducedCdrs']->renderError() ?>
    </div>
    <div class="checkbox">
      <?php echo $form['sendEmailOnMissedCall'] . "\n" ?>
      <span><?php echo $form['sendEmailOnMissedCall']->renderLabel() ?></span>
      <?php echo $form['sendEmailOnMissedCall']->renderError() ?>
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
      <?php echo $form['vm_seconds']->renderError() ?>
    </div>
    <div class="checkbox" class="voicemailField">
      <?php echo $form['vm_sendEmailOnNewMessage'] . "\n" ?>
      <span><?php echo $form['vm_sendEmailOnNewMessage']->renderLabel() ?></span>
      <?php echo $form['vm_sendEmailOnNewMessage']->renderError() ?>
    </div>
    <div class="checkbox" class="voicemailField">
      <?php echo $form['vm_attachMessage'] . "\n" ?>
      <span><?php echo $form['vm_attachMessage']->renderLabel() ?></span>
      <?php echo $form['vm_attachMessage']->renderError() ?>
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
      <?php echo $form['redirect_to']->renderError() ?>
    </div>
    <div class="redirectField">
      <span><?php echo $form['redirect_seconds']->renderLabel() ?></span>
      <?php echo $form['redirect_seconds'] . "\n" ?>
      <?php echo $form['redirect_seconds']->renderError() ?>
    </div>
  </fieldset>

  <input type="submit" value="<?php echo __('resident.settings.submit') ?>" />

  </form>