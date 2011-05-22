<?php use_javascripts_for_form($form) ?>

<div class="formContainer">
  <form action="<?php echo url_for('groupcalls/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <?php if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
    <?php endif; ?>

    <?php echo $form; ?>

    <div class="submit">
      <a href="<?php echo url_for('groupcalls/index') ?>"><?php echo __('groupcalls.backToList') ?></a>
      <?php if (!$form->getObject()->isNew()): ?>
        <?php echo link_to(__('groupcalls.delete'), 'groupcalls/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
      <?php endif; ?>
      <input type="submit" value="<?php echo __('groupcalls.submit') ?>" />
    </div>
  </form>
</div>