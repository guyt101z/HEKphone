<?php use_javascript('jquery.js') ?>
<?php use_javascript('jquery-add_remove_comments.js') ?>

<h1><?php echo __('resident.edit.heading') ?></h1>
<?php if ($sf_user->hasFlash('notice')) :?>
<div id="flash"><?php echo $sf_user->getFlash('notice') ?></div>
<?php endif;?>

<?php include_partial('form', array('form' => $form, 'resident' => $resident)) ?>
