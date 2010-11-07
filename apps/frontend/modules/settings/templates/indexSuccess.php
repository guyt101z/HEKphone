<?php if ($sf_user->hasFlash('notice')): ?>
<div class="notice">
<?php echo $sf_user->getFlash('notice') ?>
</div>
<?php endif;?>

<?php if ($sf_user->hasFlash('error')): ?>
<div class="error">
<?php echo $sf_user->getFlash('error') ?>
</div>
<?php endif;?>

<form action="<?php echo url_for('settings/index') ?>" method="post">
  <table>
  <tfoot>
    <tr>
      <td><input type="submit" value="<?php echo __('resident.settings.submit'); ?>" /></td>
    </tr>
  </tfoot>
  <?php echo $form ?>
  </table>
</form>