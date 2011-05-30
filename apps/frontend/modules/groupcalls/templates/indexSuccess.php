<table>
  <thead>
    <tr>
      <th><?php echo __('groupcalls.extension') ?></th>
      <th><?php echo __('groupcalls.name') ?></th>
      <th><?php echo __('groupcalls.residents') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Groupcalls as $Groupcall): ?>
    <tr>
      <td><a href="<?php echo url_for('groupcall_edit', array('id' =>$Groupcall->getId())) ?>"><?php echo $Groupcall->getExtension() ?></a></td>
      <td><a href="<?php echo url_for('groupcall_edit', array('id' =>$Groupcall->getId())) ?>"><?php echo $Groupcall->getName() ?></a></td>
      <td><a href="<?php echo url_for('groupcall_edit', array('id' =>$Groupcall->getId())) ?>"><?php echo $Groupcall->getMemberList() ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('groupcall_new') ?>"><?php echo __('groupcalls.new') ?></a>
