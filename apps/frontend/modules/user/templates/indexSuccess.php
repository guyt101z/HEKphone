<?php if ($sf_user->hasFlash('notice')): ?>
<div class="flash">
<?php echo $sf_user->getFlash('notice') ?>
</div>
<?php endif; ?>

<?php if ( ! $sf_user->isAuthenticated()): ?>
<form action="<?php echo url_for('user/login') ?>" method="POST">
  <table>
    <?php echo $form ?>
    <tr>
      <td colspan="2">
        <input type="submit" />
      </td>
    </tr>
  </table>
</form>
<?php else: ?>
<div>You are already logged in. <?php link_for('Log out?', 'user/logout') ?>">Log out?</div>
<?php endif;?>