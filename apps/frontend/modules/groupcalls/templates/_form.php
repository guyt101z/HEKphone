<?php use_javascripts_for_form($form) ?>

<div class="formContainer">
  <?php if($form->getObject()->isNew()): ?>
  <form action="<?php echo url_for('groupcall_create') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php else:?>
  <form action="<?php echo url_for('groupcall_update', array('id' => $form->getObject()->getId())) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php endif; ?>
    <?php if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
    <?php endif; ?>

    <?php echo $form; ?>

    <div class="submit">
      <a href="<?php echo url_for('groupcalls/index') ?>"><?php echo __('groupcalls.backToList') ?></a>
      <?php if (!$form->getObject()->isNew()): ?>
        <?php echo link_to(__('groupcalls.delete'), 'groupcall_delete', array('id' =>$form->getObject()->getId(), 'method' => 'delete', 'confirm' => 'Are you sure?')) ?>
      <?php endif; ?>
      <input type="submit" value="<?php echo __('groupcalls.submit') ?>" />
    </div>
  </form>
</div>