    <tr class="<? echo ($message->isNew())? 'new' : 'old'; ?>">
      <td><?php echo $message->getDatetime() ?></td>
      <td><?php echo $message->getCallerid() ?></td>
      <td><?php echo $message->getDuration() ?></td>
      <td>
        <a href=""><?php echo __('vm.message.listen') ?></a>
        <a href=""><?php echo __('vm.message.toggleOldNew') ?></a>
        <?php echo link_to(__('vm.message.delete'), 'voicemail/delete',
                       array('query_string' => 'id=' . $message->getId()
                               . '&new=' . $message->isNew()
                               . '&voicemailbox=' . $message->getVoicemailboxId(),
                           'method' => 'delete',
                           'confirm' => 'Are you sure?')) ?>
      </td>
    </tr>
