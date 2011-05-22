
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
foreach($vmbox->getNewMessages() as $newMessage){
    include_partial('messageRow', array('message' => $newMessage));
};
?>
  </tbody>
</table>