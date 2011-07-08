<ul id="tasks">
  <li><?php echo link_to(__('task.newBills'), 'task_newBills') ?></li>
  <li><?php echo link_to(__('task.continueWithOldBills'), 'task_continueWithOldBills') ?></li>
  <li><?php echo link_to(__('task.updateBankInformation'), '@task_updateBankInformation', array('confirm' => __('task_bank.update.sure')))?></li>
</ul>