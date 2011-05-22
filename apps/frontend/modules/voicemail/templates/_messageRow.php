    <tr class="<? echo ($message->isNew())? 'new' : 'old'; ?>">
      <td><?php echo $message->getDatetime() ?></td>
      <td><?php echo $message->getCallerid() ?></td>
      <td><?php echo $message->getDuration() ?></td>
      <td>
        <audio controls="controls" preload="metadata">
        <source src="<?php echo url_for('voicemail/listen?'
                                  . 'id=' . $message->getId()
                                  . '&new=' . (string)(int)$message->isNew()
                                  . '&voicemailbox=' . $message->getVoicemailboxId()); ?>" />
          <?php echo link_to(__('voicemail.message.listen'), 'voicemail/listen',
                       array('query_string' => 'id=' . $message->getId()
                               . '&new=' . (string)(int)$message->isNew()
                               . '&voicemailbox=' . $message->getVoicemailboxId())); ?>
        </audio><br />
        <?php echo link_to(__('voicemail.message.listen'), 'voicemail/listen',
                       array('query_string' => 'id=' . $message->getId()
                             . '&new=' . (string)(int)$message->isNew()
                             . '&voicemailbox=' . $message->getVoicemailboxId())); ?>
        <?php if($message->isNew()): ?>
        <?php echo link_to(__('voicemail.message.markAsOld'), 'voicemail/markAsOld',
                       array('query_string' => 'id=' . $message->getId()
                               . '&voicemailbox=' . $message->getVoicemailboxId())); ?>
        <?php else: ?>
        <?php echo link_to(__('voicemail.message.markAsNew'), 'voicemail/markAsNew',
                       array('query_string' => 'id=' . $message->getId()
                               . '&voicemailbox=' . $message->getVoicemailboxId())); ?>
        <?php endif;?>
        <?php echo link_to(__('voicemail.message.delete'), 'voicemail/delete',
                       array('query_string' => 'id=' . $message->getId()
                               . '&new=' . (string)(int)$message->isNew()
                               . '&voicemailbox=' . $message->getVoicemailboxId(),
                           'method' => 'delete',
                           'confirm' => 'Are you sure?')) ?>
      </td>
    </tr>
