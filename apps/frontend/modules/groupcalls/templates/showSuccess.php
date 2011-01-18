<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $Groupcall->getId() ?></td>
    </tr>
    <tr>
      <th>Extension:</th>
      <td><?php echo $Groupcall->getExtension() ?></td>
    </tr>
    <tr>
      <th>Name:</th>
      <td><?php echo $Groupcall->getName() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('groupcalls/edit?id='.$Groupcall->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('groupcalls/index') ?>">List</a>
