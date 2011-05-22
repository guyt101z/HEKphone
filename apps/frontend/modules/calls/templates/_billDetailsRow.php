    <tr>
      <td><?php echo $bill->date ?></td>
      <td><?php echo $bill->amount?>&#8239;€</td>
      <td><?php echo link_to(__('calls.list.bills.hidedetails'), '@resident_calls?residentid='.$residentid) ?></td>
    </tr>
    <tr>
      <td class="billdetails" colspan="3">
        <table class="calldetails" border="1">
          <thead>
            <?php include_partial('callDetailsHeading') ?>
          </thead>
          <tbody>
          <?php foreach($bill->getCalls() as $call):?>
            <?php include_partial('callDetailsRow', array('call' => $call)) ?>
          <?php endforeach;?>
          </tbody>
        </table>
      </td>
     </tr>