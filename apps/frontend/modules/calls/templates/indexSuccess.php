
<h1><?php echo "Listing your Calls:" ?></h1>

<table border="1">
    <tr>
      <td>Date/Time</td>
      <td>Duration</td>
      <td>Called Number</td>
      <td>Charge</td>
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

<h1><?php echo "Listing your recent Bills:" ?></h1>

<table border="1">
    <tr>
      <td>date</td>
      <td>amount</td>
      <td>details</td>
    </tr>
    <?php foreach($billsCollection as $bill): ?>
    <tr>
      <td><?php echo $bill->date ?></td>
      <td><?php echo $bill->amount?></td>
      <td><?php echo link_to('show', 'calls/index/?billid='.$bill->id) ?></td>
    </tr>
      <?php if ($sf_request->getParameter('billid') == $bill->id):?>
        <?php foreach($bill->Calls as $calldetail):?>
    <tr>
      <td><?php echo $calldetail->date ?></td>
      <td><?php echo $calldetail->charges ?></td>
      <td><?php echo $calldetail->destination ?></td>
    </tr>
        <?php endforeach;?>
      <?php endif;?>
    <?php endforeach;?>
</table>

<?php echo link_to('Log out?', 'auth/logout') ?>