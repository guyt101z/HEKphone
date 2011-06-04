  <div id="oldBills" class="active">
    <?php if(isset($bills) && $bills):
            include_partial('bills', array('bills' => $bills, 'totalAmount' => $totalAmount));
          else:
            echo __('task.bills.continue.no_bills_without_debit');
          endif;
    ?>
    <div>
      <form action="<?php echo url_for('task_newBills_chooseDate') ?>" method="POST">
        <?php echo $dateForm; echo $dateForm->renderHiddenFields(); ?>
        <input type="submit" value="<?php echo __('task.bills.continue.choose_date.submit') ?>" />
      </form>
    </div>

    <?php echo link_to(__('task.bills.continue.getDtaus'), 'task_continueWithOldBills_getDtaus') ?>
  </div>

  <div id="done" class="active">
    <?php echo link_to(__('task.bills.continue.markAsDone'), 'tasks/markAsDone',
                       array('confirm' => __('task_continueWithOldBills_sure'))) ?>
  </div>