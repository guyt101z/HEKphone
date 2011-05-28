<?php use_javascript('jquery.js') ?>
<?php use_javascript('jquery-add_remove_comments.js') ?>

<?php include_partial('form', array('form' => $form, 'resident' => $resident)) ?>

<h2>Aktionen</h2>
<ul id="actions">
  <li><?php echo link_to(__('resident.lockOnFailedDebit'), 'resident_lockOnFailedDebit', array('residentid' => $form->getObject()->getId()),
    array('confirm' => __('resident.lockOnFailedDebit.sure'))) ?> <br />
  </li>
  <li><?php echo link_to(__('resident.resetPassword'), 'resident_resetPassword', array('residentid' => $form->getObject()->getId())) ?>
  </li>
</ul>
