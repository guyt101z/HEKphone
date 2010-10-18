<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('phone/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('phone/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'phone/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['name']->renderLabel() ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['accountcode']->renderLabel() ?></th>
        <td>
          <?php echo $form['accountcode']->renderError() ?>
          <?php echo $form['accountcode'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['callerid']->renderLabel() ?></th>
        <td>
          <?php echo $form['callerid']->renderError() ?>
          <?php echo $form['callerid'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['canreinvite']->renderLabel() ?></th>
        <td>
          <?php echo $form['canreinvite']->renderError() ?>
          <?php echo $form['canreinvite'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['host']->renderLabel() ?></th>
        <td>
          <?php echo $form['host']->renderError() ?>
          <?php echo $form['host'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['port']->renderLabel() ?></th>
        <td>
          <?php echo $form['port']->renderError() ?>
          <?php echo $form['port'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['mailbox']->renderLabel() ?></th>
        <td>
          <?php echo $form['mailbox']->renderError() ?>
          <?php echo $form['mailbox'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['md5secret']->renderLabel() ?></th>
        <td>
          <?php echo $form['md5secret']->renderError() ?>
          <?php echo $form['md5secret'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['nat']->renderLabel() ?></th>
        <td>
          <?php echo $form['nat']->renderError() ?>
          <?php echo $form['nat'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['permit']->renderLabel() ?></th>
        <td>
          <?php echo $form['permit']->renderError() ?>
          <?php echo $form['permit'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['deny']->renderLabel() ?></th>
        <td>
          <?php echo $form['deny']->renderError() ?>
          <?php echo $form['deny'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['mask']->renderLabel() ?></th>
        <td>
          <?php echo $form['mask']->renderError() ?>
          <?php echo $form['mask'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['qualify']->renderLabel() ?></th>
        <td>
          <?php echo $form['qualify']->renderError() ?>
          <?php echo $form['qualify'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['secret']->renderLabel() ?></th>
        <td>
          <?php echo $form['secret']->renderError() ?>
          <?php echo $form['secret'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['type']->renderLabel() ?></th>
        <td>
          <?php echo $form['type']->renderError() ?>
          <?php echo $form['type'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['username']->renderLabel() ?></th>
        <td>
          <?php echo $form['username']->renderError() ?>
          <?php echo $form['username'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['defaultuser']->renderLabel() ?></th>
        <td>
          <?php echo $form['defaultuser']->renderError() ?>
          <?php echo $form['defaultuser'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['useragent']->renderLabel() ?></th>
        <td>
          <?php echo $form['useragent']->renderError() ?>
          <?php echo $form['useragent'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['fromuser']->renderLabel() ?></th>
        <td>
          <?php echo $form['fromuser']->renderError() ?>
          <?php echo $form['fromuser'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['fromdomain']->renderLabel() ?></th>
        <td>
          <?php echo $form['fromdomain']->renderError() ?>
          <?php echo $form['fromdomain'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['disallow']->renderLabel() ?></th>
        <td>
          <?php echo $form['disallow']->renderError() ?>
          <?php echo $form['disallow'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['allow']->renderLabel() ?></th>
        <td>
          <?php echo $form['allow']->renderError() ?>
          <?php echo $form['allow'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['ipaddr']->renderLabel() ?></th>
        <td>
          <?php echo $form['ipaddr']->renderError() ?>
          <?php echo $form['ipaddr'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['mac']->renderLabel() ?></th>
        <td>
          <?php echo $form['mac']->renderError() ?>
          <?php echo $form['mac'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['fullcontact']->renderLabel() ?></th>
        <td>
          <?php echo $form['fullcontact']->renderError() ?>
          <?php echo $form['fullcontact'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['regexten']->renderLabel() ?></th>
        <td>
          <?php echo $form['regexten']->renderError() ?>
          <?php echo $form['regexten'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['regserver']->renderLabel() ?></th>
        <td>
          <?php echo $form['regserver']->renderError() ?>
          <?php echo $form['regserver'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['regseconds']->renderLabel() ?></th>
        <td>
          <?php echo $form['regseconds']->renderError() ?>
          <?php echo $form['regseconds'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['lastms']->renderLabel() ?></th>
        <td>
          <?php echo $form['lastms']->renderError() ?>
          <?php echo $form['lastms'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
