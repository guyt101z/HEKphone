<h2><?php echo __('voicemail.newMessages') ?></h2>

<table>
  <thead>
    <tr>
      <td><?php echo __('voicemail.date') ?></td>
      <td><?php echo __('voicemail.callerid') ?></td>
      <td><?php echo __('voicemail.duration') ?></td>
      <td><?php echo __('voicemail.actions') ?></td>
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

<h2><?php echo __('voicemail.oldMessages') ?></h2>

<table>
  <thead>
    <tr>
      <td><?php echo __('voicemail.date') ?></td>
      <td><?php echo __('voicemail.callerid') ?></td>
      <td><?php echo __('voicemail.duration') ?></td>
      <td><?php echo __('voicemail.actions') ?></td>
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
