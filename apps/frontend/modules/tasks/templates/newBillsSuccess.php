<?php if($sf_user->hasFlash('error')): ?>
<div id="error"> <?php echo $sf_user->getFlash('error')?></div>
<?php endif;?>

<div <?php if($step == 1) { echo 'class="active"'; } ?>>
  <form action="<?php echo url_for('task_newBills_simulate') ?>" method="POST">
    <?php echo __('task.bills.create.simulate') ?>
    <?php echo $dateForm; echo $dateForm->renderHiddenFields(); ?>
    <input type="submit" value="<?php echo __('task.bills.create.simulate.submit') ?>" />
  </form>
</div>
<?php if($bills): include_partial('bills', array('bills' => $bills, 'totalAmount' => $totalAmount)); endif; ?>
<div <?php if($step == 2) { echo 'class="active"'; } ?>>
    <form action="<?php echo url_for('task_newBills_create') ?>" method="POST">
      <input type="submit" <?php if($step != 2) { echo 'disabled="disabled" '; } ?> value="<?php echo __('task.bills.create.createAndSend') ?>" />
    </form>
</div>