<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('resident/update' . '?residentid='.$form->getObject()->getId()) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<input type="hidden" name="sf_method" value="put" />
  <table>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo __('resident.last_name') ?></th>
        <td>
          <?php echo $resident['last_name']  . "\n"?>
        </td>
      </tr>
      <tr>
        <th><?php echo __('resident.first_name') ?></th>
        <td>
          <?php echo $resident['first_name'] . "\n" ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['email']->renderLabel() ?></th>
        <td>
          <?php echo $form['email']->renderError() ?>
          <?php echo $form['email'] . "\n" ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['bill_limit']->renderLabel() ?></th>
        <td>
          <?php echo $form['bill_limit']->renderError() ?>
          <?php echo $form['bill_limit'] . "\n" ?>
        </td>
      </tr>
      <tr>
        <th><?php echo __('resident.room_no') ?></th>
        <td>
          <?php echo $resident['Rooms']['room_no'] . "\n" ?>
        </td>
      </tr>
      <tr>
        <th><?php echo __('resident.warning1') ?></th>
        <td>
          <?php echo ( $resident['warning1'] )? __('resident.warning.true') : __('resident.warning.false'); ?>
        </td>
      </tr>
      <tr>
        <th><?php echo __('resident.warning2') ?></th>
        <td>
          <?php echo ( $resident['warning2'] )? __('resident.warning.true') : __('resident.warning.false'); ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['unlocked']->renderLabel() ?></th>
        <td>
          <?php echo $form['unlocked']->renderError() ?>
          <?php echo $form['unlocked'] . "\n" ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['shortened_itemized_bill']->renderLabel() ?></th>
        <td>
          <?php echo $form['shortened_itemized_bill']->renderError() ?>
          <?php echo $form['shortened_itemized_bill'] . "\n" ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['hekphone']->renderLabel() ?></th>
        <td>
          <?php echo $form['hekphone']->renderError() ?>
          <?php echo $form['hekphone'] . "\n" ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['account_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['account_number']->renderError() ?>
          <?php echo $form['account_number'] . "\n" ?>
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
  <ul id="comments">
    <?php foreach ($form['comments'] as $commentFields): ?>
      <li>
        <?php //FIXME: Print the timestamp of the comment here?>
        <?php echo $commentFields ?>
        <a href="#"><?php echo __('resident.edit.removeThisComment') ?></a>
      </li>
  <?php endforeach; ?>
  </ul>
  <a id="addComment" href="#"><?php echo __('resident.edit.addComment')?></a>
  <div class="formFoot">
    <?php echo $form->renderHiddenFields(false) ?>
    &nbsp;<?php echo link_to(__('resident.edit.backToList'), 'resident/index') ?>
    <input type="submit" value="<?php echo __('resident.edit.save') ?>" />
  </div>
</form>
