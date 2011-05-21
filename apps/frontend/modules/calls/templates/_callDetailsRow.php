    <tr>
      <td><?php echo $call->date ?></td>
      <td><?php echo $call->duration?>&#8239;sec</td>
      <td><?php echo $call->Rates->get('name') ?></td>
      <td><?php echo $call->destination ?></td>
      <td><?php echo $call->charges ?>&#8239;ct</td>
    </tr>