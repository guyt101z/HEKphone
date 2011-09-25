<section id="new">
  <h2><?php echo __('voicemail.newMessages') ?></h2>

  <?php if(count($vmbox->getNewMessages()) > 0):?>
  <table>
    <thead>
      <tr>
        <th><?php echo __('voicemail.date') ?></th>
        <th><?php echo __('voicemail.callerid') ?></th>
        <th><?php echo __('voicemail.duration') ?></th>
        <th><?php echo __('voicemail.actions') ?></th>
      </tr>
    </thead>
    <tbody>
  <?php
  foreach($vmbox->getNewMessages() as $message){
      include_partial('messageRow', array('message' => $message));
  };
  ?>
    </tbody>
  </table>
  <?php else:?>
  <p><?php echo __('voicemail.noNewMessages')?></p>
  <?php endif;?>
  <?php ?>
</section>

<?php if(count($vmbox->getOldMessages()) > 0):?>
<section id="old">
  <h2><?php echo __('voicemail.oldMessages') ?></h2>

  <table>
    <thead>
      <tr>
        <th><?php echo __('voicemail.date') ?></th>
        <th><?php echo __('voicemail.callerid') ?></th>
        <th><?php echo __('voicemail.duration') ?></th>
        <th><?php echo __('voicemail.actions') ?></th>
      </tr>
    </thead>
    <tbody>
  <?php
  foreach($vmbox->getOldMessages() as $message){
      include_partial('messageRow', array('message' => $message));
  };
  ?>
    </tbody>
  </table>
</section>
<?php endif;?>