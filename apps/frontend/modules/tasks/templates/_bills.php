<table>
  <thead>
    <tr><th><?php echo __('task.bills.residentid') ?></th><th><?php echo __('task.bills.amount') ?></th></tr>
    <tr><td><?php echo __('task.bills.total_amount') ?> <?php echo $totalAmount?></td><td><?php echo __('task.bills.number') ?> <?php echo count($bills) ?></td></tr>
  </thead>
  <tbody>
    <?php foreach($bills as $bill): ?>
    <tr>
      <td><a href="<?php echo url_for('@resident_calls?residentid=' . $bill['resident']) ?>"><?php echo $bill['resident'] ?></a></td>
      <td><?php echo $bill['amount'] ?> €</td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>