<?php use_javascript('jquery.js') ?>

<h1><?php echo __('calls.heading') ?></h1>

<?php include_partial('getCharges'); ?>

<h2><?php echo __("calls.list.heading") ?></h2>
<table border="1">
    <thead>
        <?php include_partial('callDetailsHeading') ?>
    </thead>
    <?php $sum = 0;?>
    <?php foreach($callsCollection as $call): ?>
      <?php include_partial('callDetailsRow', array('call' => $call)) ?>
      <?php $sum += $call->charges; ?>
    <?php endforeach;?>
    <tfoot>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><?php echo __('calls.list.sum') ?></td>
        <td><?php echo $sum/100 ?>&#8239;€</td>
      </tr>
    </tfoot>
</table>

<h2><?php echo __("calls.list.bills.heading") ?></h2>

<table border="1">
    <thead>
      <tr>
        <th><?php echo __("calls.list.bills.date") ?></th>
        <th><?php echo __("calls.list.bills.amount") ?></th>
        <th><?php echo __("calls.list.bills.details") ?></th>
        <th><?php if($sf_user->hasCredential('hekphone')):
                      echo __("calls.list.bills.actions");
                  endif;?>
        </t
        h>
      </tr>
    </thead>
    <?php foreach($billsCollection as $bill): ?>
      <?php if ($sf_request->getParameter('billid') == $bill->id): ?>
        <?php include_partial('billDetailsRow', array('bill' => $bill, 'residentid' => $residentid)) ?>
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