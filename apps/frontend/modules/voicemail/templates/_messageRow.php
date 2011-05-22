    <tr class="<? echo ($message->isNew())? 'new' : 'old'; ?>">
      <td><?php echo $message->getDatetime() ?></td>
      <td><?php echo $message->getCallerid() ?></td>
      <td><?php echo $message->getDuration() ?></td>
      <td>
        <a href=""><?php echo __('vm.message.listen') ?></a>
        <?php if($message->isNew()): ?>
        <?php echo link_to(__('vm.message.markAsOld'), 'voicemail/markAsOld',
                       array('query_string' => 'id=' . $message->getId()
                               . '&voicemailbox=' . $message->getVoicemailboxId())); ?>
        <?php else: ?>
        <?php echo link_to(__('vm.message.markAsNew'), 'voicemail/markAsNew',
                       array('query_string' => 'id=' . $message->getId()
                               . '&voicemailbox=' . $message->getVoicemailboxId())); ?>
        <?php endif;?>
        <?php echo link_to(__('vm.message.delete'), 'voicemail/delete',
                       array('query_string' => 'id=' . $message->getId()
                               . '&new=' . (string)(int)$message->isNew()
                               . '&voicemailbox=' . $message->getVoicemailboxId(),
                           'method' => 'delete',
                           'confirm' => 'Are you sure?')) ?>
      </td>
    </tr>
