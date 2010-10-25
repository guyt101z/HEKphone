<?php if ($sf_user->hasFlash('notice')): ?>
<div class="flash">
<?php echo $sf_user->getFlash('notice') ?>
</div>
<?php endif;?>

<?php if ( ! $sf_user->isAuthenticated()): ?>
<form action="<?php echo url_for('auth/index') ?>" method="POST">
  <table>
    <?php echo $form ?>
    <tr>
      <td colspan="2">
        <input type="submit" value="<?php echo __('auth.submit'); ?>" />
      </td>
    </tr>
  </table>
</form>
<?php else: ?>
<div>You are already logged in. <?php echo link_to(__('auth.logout'), 'auth/logout'); ?></div>
<?php endif;?>

<?php
  // So the task i18n:extract does not delete form labels and flashes
   __('auth.password');
   __('auth.roomNo');
   __('auth.login.failed');
   __('auth.login.successfull');
   __('auth.logout.successfull');
 ?>