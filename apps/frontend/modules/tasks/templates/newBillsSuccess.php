<div id="dateForm" <?php if($step == 1) { echo 'class="active"'; } ?>>
  <span><?php echo __('task.bills.create.simulate') ?></span>
  <form action="<?php echo url_for('task_newBills_simulate') ?>" method="POST">
    <?php echo $dateForm; echo $dateForm->renderHiddenFields(); ?>
    <input type="submit" value="<?php echo __('task.bills.create.simulate.submit') ?>" />
  </form>
</div>

<div id="create" <?php if($step == 2) { echo 'class="active"'; } ?>>
  <?php if($bills): include_partial('bills', array('bills' => $bills, 'totalAmount' => $totalAmount)); endif; ?>
  <form action="<?php echo url_for('task_newBills_create') ?>" method="POST">
    <input type="submit" <?php if($step != 2) { echo 'disabled="disabled" '; } ?> value="<?php echo __('task.bills.create.createAndSend') ?>" />
  </form>
</div>

<p id="backToTasks" <?php if($step == 3) { echo 'class="active"'; } ?>>
  <?php echo link_to(__('task.bills.create.backToTasks'), 'tasks') ?>
</p>