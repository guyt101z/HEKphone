<h1>HEKPhone Portal</h1>

<div id="info">
  <p><?php echo __('auth.hekphoneinfo') ?></p>
</div>

<div id="login">
  <p><?php echo __('auth.login.explanation') ?></p>
  <?php if ( ! $sf_user->isAuthenticated()): ?>
  <form action="<?php echo url_for('auth/index') ?>" method="post">
    <?php echo $form ?>
    <div><input type="submit" id="submit" value="<?php echo __('auth.submit'); ?>" /></div>
  </form>
  <?php else: ?>
  <div><?php echo __('auth.alreadyLoggedIn') ?> <?php echo link_to(__('auth.logout'), 'auth/logout') ?></div>
  <?php endif;?>
</div>
