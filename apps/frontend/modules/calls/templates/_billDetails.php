<?php foreach($bill->Calls as $calldetail):?>
    <tr>
      <td><?php echo $calldetail->date ?></td>
      <td><?php echo $calldetail->charges ?></td>
      <td><?php echo $calldetail->destination ?></td>
    </tr>
<?php endforeach;?>