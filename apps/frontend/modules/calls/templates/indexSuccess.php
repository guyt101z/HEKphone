<?php use_javascript('jquery.js') ?>

<h1><?php echo __("calls.list.heading") ?></h1>

<?php if ($sf_user->hasFlash('notice')) :?>
<div id="flash"><?php echo $sf_user->getFlash('notice') ?></div>
<?php endif;?>

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
      <th><?php if($sf_user->hasCredential('hekphone')):
                    echo __("calls.list.bills.actions");
                endif;?>
      </th>          
      
    </tr>
    <?php foreach($billsCollection as $bill): ?>
    <?php if ($sf_request->getParameter('billid') == $bill->id): ?>
      <?php include_partial('billDetails', array('bill' => $bill, 'residentid' => $residentid)) ?>
    <?php continue; ?>
    <?php endif;?>
    <tr>
      <td><?php echo $bill->date ?></td>
      <td><?php echo $bill->amount?></td>
      <td><?php echo link_to(__('calls.list.bills.showdetails'), '@resident_calls?residentid='.$residentid.'&billid='.$bill->id)?></td>
      <td><?php if($sf_user->hasCredential('hekphone')):
                    echo link_to(__('calls.list.bills.sendEmail'),'calls/sendBillEmail?billid=' . $bill->id);
                endif;?></td>
    </tr>
    <?php endforeach;?>
</table>