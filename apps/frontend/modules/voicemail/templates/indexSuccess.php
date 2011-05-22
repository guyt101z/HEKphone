<h2><?php echo __('voicemail.newMessages') ?></h2>

<table>
  <thead>
    <tr>
      <td><?php echo __('vm.date') ?></td>
      <td><?php echo __('vm.callerid') ?></td>
      <td><?php echo __('vm.duration') ?></td>
      <td><?php echo __('vm.actions') ?></td>
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
      <td><?php echo __('vm.date') ?></td>
      <td><?php echo __('vm.callerid') ?></td>
      <td><?php echo __('vm.duration') ?></td>
      <td><?php echo __('vm.actions') ?></td>
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
