<table>
  <thead>
    <tr>
      <th><?php echo __('task.bills.residentid') ?></th>
      <th><?php echo __('task.bills.amount') ?></th>
      <th><?php echo __('task.bills.date') ?></th>
      <th><?php echo __('task.bills.actions') ?></th>
    </tr>
    <tr>
      <td><?php echo __('task.bills.total_amount') ?> <?php echo $totalAmount?></td>
      <td><?php echo __('task.bills.number') ?> <?php echo count($bills) ?></td>
      <td></td>
      <td></td>
    </tr>
  </thead>
  <tbody>
    <?php foreach($bills as $bill): ?>
    <tr <?php  if($bill['debit_sent']): echo ' class="already_debited"'; endif; ?>>
      <td><a href="<?php echo url_for('@resident_calls?residentid=' . $bill['resident']) ?>"><?php echo $bill['resident'] ?></a></td>
      <td><?php echo $bill['amount'] ?> €</td>
      <td><?php echo $bill['date'] ?></td>
      <td><?php echo link_to(__('task.bills.remove'), 'task_removeFromCollection', array('billid' => $bill['id'])) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>