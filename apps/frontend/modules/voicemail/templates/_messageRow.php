      <tr>
        <td><?php echo $message->getDatetime() ?></td>
        <td><?php echo $message->getCallerid() ?></td>
        <td><?php echo $message->getDuration() ?></td>
        <td>
          <audio controls="controls" preload="none">
          <source src="<?php echo url_for('voicemail_listen',
                                      array('messageid' =>  $message->getId(),
                                          'new' => (string)(int)$message->isNew(),
                                          'voicemailbox' => $message->getVoicemailboxId()
                                      )); ?>" />
            <?php echo link_to(__('voicemail.message.listen'), 'voicemail_listen',
                                      array('messageid' =>  $message->getId(),
                                          'new' => (string)(int)$message->isNew(),
                                          'voicemailbox' => $message->getVoicemailboxId()
                                      )); ?>
          </audio><br />
          <?php echo link_to(__('voicemail.message.listen'), 'voicemail_listen',
                                      array('messageid' =>  $message->getId(),
                                          'new' => (string)(int)$message->isNew(),
                                          'voicemailbox' => $message->getVoicemailboxId()
                                      )); ?>
          <?php if($message->isNew()): ?>
          <?php echo link_to(__('voicemail.message.markAsOld'), 'voicemail_markAsOld',
                                      array('messageid' =>  $message->getId(),
                                          'new' => (string)(int)true,
                                          'voicemailbox' => $message->getVoicemailboxId()
                                      )); ?>
          <?php else: ?>
          <?php echo link_to(__('voicemail.message.markAsNew'), 'voicemail_markAsNew',
                                      array('messageid' =>  $message->getId(),
                                          'new' => (string)(int)true,
                                          'voicemailbox' => $message->getVoicemailboxId()
                                      )); ?>
          <?php endif;?>
          <?php echo link_to(__('voicemail.message.delete'), '@voicemail_delete?'
                                        . 'messageid=' . $message->getId()
                                        . '&new=' . (string)(int)$message->isNew()
                                        . '&voicemailbox=' . $message->getVoicemailboxId(),
                                      array(
                                          'method' => 'delete',
                                          'confirm' => 'Are you sure?')
                                      ); ?>
        </td>
      </tr>
