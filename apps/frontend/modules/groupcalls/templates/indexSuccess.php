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
      <td><a href="<?php echo url_for('groupcalls/edit?id='.$Groupcall->getId()) ?>"><?php echo $Groupcall->getExtension() ?></a></td>
      <td><?php echo $Groupcall->getName() ?></td>
      <td><?php echo $Groupcall->getMemberList() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('groupcalls/new') ?>"><?php echo __('groupcalls.new') ?></a>
