<h1><?php echo __("calls.list.heading") ?></h1>

<table border="1">
    <tr>
      <td><?php echo __("calls.list.datetime") ?></td>
      <td><?php echo __("calls.list.duration") ?></td>
      <td><?php echo __("calls.list.destination") ?></td>
      <td><?php echo __("calls.list.charge") ?></td>
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


<h1><?php echo __("calls.list.bills.heading") ?></h1>

<table border="1">
    <tr>
      <td><?php echo __("calls.list.bills.date") ?></td>
      <td><?php echo __("calls.list.bills.amount") ?></td>
      <td><?php echo __("calls.list.bills.details") ?></td>
    </tr>
    <?php foreach($billsCollection as $bill): ?>
    <tr>
      <td><?php echo $bill->date ?></td>
      <td><?php echo $bill->amount?></td>
      <td><?php echo link_to(__('calls.list.bills.showdetails'), 'calls/index/?billid='.$bill->id) ?></td>
    </tr>
    <?php if ($sf_request->getParameter('billid') == $bill->id): ?>
    <tr><?php include_partial('billDetails', array('bill' => $bill)) ?></tr>
    <?php endif;?>
    <?php endforeach;?>
</table>

<?php echo link_to(__('auth.logout') . '?', 'auth/logout') ?>