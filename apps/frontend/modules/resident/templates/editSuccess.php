<?php use_javascript('jquery.js') ?>
<?php use_javascript('jquery-add_remove_comments.js') ?>

<?php include_partial('form', array('form' => $form, 'resident' => $resident)) ?>

<h3>Aktionen</h3>
<ul>
  <li><?php echo link_to(__('resident.lockOnFailedDebit'), 'resident/lockOnFailedDebit?id=' . $form->getObject()->getId(),
    array('confirm' => __('resident.lockOnFailedDebit.sure'))) ?> <br />
  </li>
  <li><?php echo link_to(__('resident.resetPassword'), 'resident/resetPassword?id=' . $form->getObject()->getId()) ?>
  </li>
</ul>
