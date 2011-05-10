<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('groupcalls/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('groupcalls/index') ?>"><?php echo __('groupcalls.backToList') ?></a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to(__('groupcalls.delete'), 'groupcalls/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="<?php echo __('groupcalls.submit') ?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo __('groupcalls.extension') ?></th>
        <td>
          <?php echo $form['extension']->renderError() ?>
          <?php echo $form['extension'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo __('groupcalls.name') ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo __('groupcalls.mode') ?></th>
        <td>
          <?php echo $form['mode']->renderError() ?>
          <?php echo $form['mode'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo __('groupcalls.residents') ?></th>
        <td>
          <?php echo $form['residents_list']->renderError() ?>
          <?php echo $form['residents_list'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
