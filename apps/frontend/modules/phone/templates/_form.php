<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="formContainer" id="phones">
  <?php if($form->getObject()->isNew()): ?>
  <form action="<?php echo url_for('phone_create') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php else:?>
  <form action="<?php echo url_for('phone_update', array('id' => $form->getObject()->getId())) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php endif;?>
    <?php if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
    <?php endif; ?>
    <?php echo $form; ?>
    <div class="submit">
      <a href="<?php echo url_for('phone/index') ?>"><?php echo __('phone.back_to_list') ?></a>
      <?php if (!$form->getObject()->isNew()): ?>
      <?php echo link_to(__('phone.delete'), '@phone_delete?id='. $form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
      <?php endif;?>
      <?php echo $form->renderHiddenFields() ?>
      <input type="submit" value="<?php echo __('phone.submit') ?>" />
    </div>
  </form>
</div>
