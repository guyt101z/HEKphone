<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="formContainer">
  <form action="<?php echo url_for('resident_update', array('residentid' => $form->getObject()->getId())) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <input type="hidden" name="sf_method" value="put" />
    <?php echo $form->renderHiddenFields(false) ?>
    <?php echo $form->renderGlobalErrors() ?>
    <div class="entry">
      <label for="last_name"><?php echo __('resident.last_name') ?></label>
      <span class="value" id="last_name"><?php echo $resident['last_name']; ?></span>
    </div>
    <div class="entry">
      <label for="first_name"><?php echo __('resident.first_name') ?></label>
      <span class="value"  id="first_name"><?php echo $resident['first_name']; ?></span>
    </div>
    <div class="entry">
      <?php echo $form['email']->renderLabel() . "\n"; ?>
      <?php echo $form['email'] . "\n"; ?>
      <?php echo $form['email']->renderError() ?>
    </div>
    <div class="entry">
        <?php echo $form['bill_limit']->renderLabel() . "\n"; ?>
        <?php echo $form['bill_limit'] . "\n" ?>
        <?php echo $form['bill_limit']->renderError() ?>
    </div>
    <div class="entry">
      <label for="room_no"><?php echo __('resident.room_no') ?></label>
      <span class="value"  id="room_no"><?php echo $resident['Rooms']['room_no'] . "\n" ?></span>
    </div>
    <div class="entry">
      <label for="warning1"><?php echo __('resident.warning1') ?></label>
      <span class="value"  id="warning1"><?php echo ( $resident['warning1'] )? __('resident.warning.true') : __('resident.warning.false'); ?></span>
    </div>
    <div class="entry">
      <label for="warning2"><?php echo __('resident.warning2') ?></label>
      <span class="value"  id="warning2"><?php echo ( $resident['warning2'] )? __('resident.warning.true') : __('resident.warning.false'); ?></span>
    </div>
    <div class="entry">
        <?php echo $form['unlocked']->renderLabel() . "\n"; ?>
        <?php echo $form['unlocked'] . "\n" ?>
        <?php echo $form['unlocked']->renderError() ?>
    </div>
    <div class="entry">
        <?php echo $form['shortened_itemized_bill']->renderLabel() . "\n"; ?>
        <?php echo $form['shortened_itemized_bill'] . "\n" ?>
        <?php echo $form['shortened_itemized_bill']->renderError() ?>
    </div>
    <div class="entry">
        <?php echo $form['hekphone']->renderLabel() . "\n"; ?>
        <?php echo $form['hekphone'] . "\n" ?>
        <?php echo $form['hekphone']->renderError() ?>
    </div>
    <div class="entry">
        <?php echo $form['account_number']->renderLabel() . "\n"; ?>
        <?php echo $form['account_number'] . "\n" ?>
        <?php echo $form['account_number']->renderError() ?>
    </div>
    <div class="entry">
        <?php echo $form['bank_number']->renderLabel() . "\n"; ?>
        <?php echo $form['bank_number'] . "\n" ?>
        <?php echo $form['bank_number']->renderError() ?>
    </div>
    <div class="entry">
      <label><?php echo __('resident.edit.comments'); ?></label>
      <ul id="comments">
        <?php foreach ($form['comments'] as $commentFields): ?>
          <li>
            <?php //FIXME: Print the timestamp of the comment here?>
            <?php echo $commentFields . "\n"; ?>
            <a href="#"><?php echo __('resident.edit.removeThisComment') ?></a>
          </li>
      <?php endforeach; ?>
      </ul>
      <a id="addComment" href="#"><?php echo __('resident.edit.addComment')?></a>
    </div>

    <div class="submit">
      <?php echo link_to(__('resident.edit.backToList'), 'residents') ?>
      <input type="submit" value="<?php echo __('resident.edit.save') ?>" />
    </div>

  </form>
</div>
