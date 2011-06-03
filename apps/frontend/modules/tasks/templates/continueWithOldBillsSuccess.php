<?php if($sf_user->hasFlash('error')): ?>
<div id="error"> <?php echo $sf_user->getFlash('error')?></div>
<?php endif;?>


  <div <?php if($step == 1 || ! $step) { echo 'class="active"'; } ?>>
    <?php if(isset($bills) && $bills):
            include_partial('bills', array('bills' => $bills, 'totalAmount' => $totalAmount));
          else:
            echo __('task.bills.continue.no_bills_without_debit');
          endif;
    ?>
    <p><?php echo __('task.bills.continue.chooseDate') ?> <?php echo __('task.bills.continue.chooseDate.includeAlreadyDebited') ?></p>
    <?php echo __('task.bills.continue.getDtaus') ?>
  </div>

  <div <?php if($step == 2) { echo 'class="active"'; } ?>>
    <?php echo __('task.bills.continue.markAsDone') ?>
  </div>