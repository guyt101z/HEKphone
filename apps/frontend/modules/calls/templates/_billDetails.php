    <tr>
      <td><?php echo $bill->date ?></td>
      <td><?php echo $bill->amount?></td>
      <td><?php echo link_to(__('calls.list.bills.hidedetails'), '@resident_calls?residentid='.$residentid) ?></td>
    </tr>
    <tr>
      <td colspan="3">
      <table class="calldetails" border="1">
    <?php foreach($bill->getCalls() as $call):?>
        <tr>
          <th><?php echo __("calls.list.datetime") ?></th>
          <th><?php echo __("calls.list.duration") ?></th>
          <th><?php echo __("calls.list.destination") ?></th>
          <th><?php echo __("calls.list.charge") ?></th>
        </tr>
        <tr>
          <td><?php echo $call->date ?></td>
          <td><?php echo $call->duration?></td>
          <td><?php echo $call->destination ?></td>
          <td><?php echo $call->charges ?></td>
        </tr>
    <?php endforeach;?>
        </table>
        </td>
     </tr>