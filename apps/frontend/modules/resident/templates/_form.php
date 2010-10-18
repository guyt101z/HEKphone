<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('resident/update' . '?id='.$form->getObject()->getId()) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<input type="hidden" name="sf_method" value="put" />
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('resident/index') ?>">Back to list</a>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo __('resident.last_name') ?></th>
        <td>
          <?php echo $resident['last_name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo __('resident.first_name') ?></th>
        <td>
          <?php echo $resident['first_name'] ?>
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
        <th><?php echo __('resident.room_no') ?></th>
        <td>
          <?php echo $resident['Rooms']['room_no'] ?>
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
        <th><?php echo $form['hekphone']->renderLabel() ?></th>
        <td>
          <?php echo $form['hekphone']->renderError() ?>
          <?php echo $form['hekphone'] ?>
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
        <th><?php echo $form['bank_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['bank_number']->renderError() ?>
          <?php echo $form['bank_number'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['password']->renderLabel() ?></th>
        <td>
          <?php echo $form['password']->renderError() ?>
          <?php echo $form['password'] ?>
        </td>
      </tr>
    </tbody>
  </table>
  <ul>
    <?php foreach ($form['comments'] as $commentFields): ?>
      <li>
        <table><?php echo $commentFields ?></table>
        <a href="javascript:remove_comment(this)"><?php echo __('resident.edit.removeThisComment') ?></a>
      </li>
    <?php endforeach ?>
  </ul>
  <a href="javascript:add_comment()"><?php echo __('resident.edit.addComment')?></a>
</form>
