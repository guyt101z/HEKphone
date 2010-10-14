
<h1><?php echo "Listing your Calls:" ?></h1>

<table border="1">
    <tr>
      <td>Datum/Zeit</td>
      <td>Dauer</td>
      <td>Nummer</td>
      <td>Kosten</td>
    </tr>
    <?php foreach($callsCollection as $call): ?>
    <tr>
      <td><?php echo $call->date ?></td>
      <td><?php echo $call->duration?></td>
      <td><?php echo $call->destination ?></td>
      <td><?php echo $call->charges ?></td>
    </tr>
    <?php endforeach;?>
</table>

<?php echo link_to('Log out?', 'auth/logout') ?>