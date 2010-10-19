<?php use_javascript('jquery.js') ?>

<h1><?php echo __("calls.list.heading") ?></h1>

<table border="1">
    <tr>
      <th><?php echo __("calls.list.datetime") ?></th>
      <th><?php echo __("calls.list.duration") ?></th>
      <th><?php echo __("calls.list.destination") ?></th>
      <th><?php echo __("calls.list.charge") ?></th>
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
      <th><?php echo __("calls.list.bills.date") ?></th>
      <th><?php echo __("calls.list.bills.amount") ?></th>
      <th><?php echo __("calls.list.bills.details") ?></th>
    </tr>
    <?php foreach($billsCollection as $bill): ?>
    <?php if ($sf_request->getParameter('billid') == $bill->id): ?>
    <tr>
      <?php include_partial('billDetails', array('bill' => $bill, 'residentid' => $residentid)) ?>
    </tr>
    <?php continue; ?>
    <?php endif;?>
    <tr>
      <td><?php echo $bill->date ?></td>
      <td><?php echo $bill->amount?></td>
      <td><?php echo link_to(__('calls.list.bills.showdetails'), '@resident_calls?residentid='.$residentid.'&billid='.$bill->id)?></td>
    </tr>
    <?php endforeach;?>
</table>

<?php echo link_to(__('auth.logout') . '?', 'auth/logout') ?>