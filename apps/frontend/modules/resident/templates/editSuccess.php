<?php use_javascript('jquery.js') ?>

<h1><?php echo __('resident.edit.heading') ?></h1>

<?php include_partial('form', array('form' => $form, 'resident' => $resident)) ?>
