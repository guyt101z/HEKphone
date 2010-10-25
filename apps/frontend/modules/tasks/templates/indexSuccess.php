<?php if($sf_user->hasFlash('error')): ?>
<div id="error"> <?php echo $sf_user->getFlash('error')?></div>
<?php endif;?>

<ul id="tasks">
  <li><?php echo link_to(__('task.billCall.billwithuniqueid'), 'tasks/billCall?uniqueid=bla') ?></li>
</ul>