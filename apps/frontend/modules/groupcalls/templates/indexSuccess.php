<h1>Groupcalls List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Extension</th>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Groupcalls as $Groupcall): ?>
    <tr>
      <td><a href="<?php echo url_for('groupcalls/show?id='.$Groupcall->getId()) ?>"><?php echo $Groupcall->getId() ?></a></td>
      <td><?php echo $Groupcall->getExtension() ?></td>
      <td><?php echo $Groupcall->getName() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('groupcalls/new') ?>">New</a>
