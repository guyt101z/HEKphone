<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('resident/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('resident/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'resident/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['last_name']->renderLabel() ?></th>
        <td>
          <?php echo $form['last_name']->renderError() ?>
          <?php echo $form['last_name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['first_name']->renderLabel() ?></th>
        <td>
          <?php echo $form['first_name']->renderError() ?>
          <?php echo $form['first_name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['email']->renderLabel() ?></th>
        <td>
          <?php echo $form['email']->renderError() ?>
          <?php echo $form['email'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['bill_limit']->renderLabel() ?></th>
        <td>
          <?php echo $form['bill_limit']->renderError() ?>
          <?php echo $form['bill_limit'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['room']->renderLabel() ?></th>
        <td>
          <?php echo $form['room']->renderError() ?>
          <?php echo $form['room'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['warning1']->renderLabel() ?></th>
        <td>
          <?php echo $form['warning1']->renderError() ?>
          <?php echo $form['warning1'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['warning2']->renderLabel() ?></th>
        <td>
          <?php echo $form['warning2']->renderError() ?>
          <?php echo $form['warning2'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['unlocked']->renderLabel() ?></th>
        <td>
          <?php echo $form['unlocked']->renderError() ?>
          <?php echo $form['unlocked'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['shortened_itemized_bill']->renderLabel() ?></th>
        <td>
          <?php echo $form['shortened_itemized_bill']->renderError() ?>
          <?php echo $form['shortened_itemized_bill'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['account_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['account_number']->renderError() ?>
          <?php echo $form['account_number'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['password']->renderLabel() ?></th>
        <td>
          <?php echo $form['password']->renderError() ?>
          <?php echo $form['password'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['bank_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['bank_number']->renderError() ?>
          <?php echo $form['bank_number'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
