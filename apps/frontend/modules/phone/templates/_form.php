<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="formContainer" id="phones">
  <form action="<?php echo url_for('phone/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <?php if (!$form->getObject()->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
    <?php endif; ?>
    <?php echo $form; ?>
    <div class="submit">
      <a href="<?php echo url_for('phone/index') ?>"><?php echo __('phone.back_to_list') ?></a>
      <?php if (!$form->getObject()->isNew()): ?>
      <?php echo link_to(__('phone.delete'), 'phone/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
      <?php endif;?>
      <input type="submit" value="<?php echo __('phone.submit') ?>" />
    </div>
  </form>
</div>
