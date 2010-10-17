<h1><?php echo __("resident.list.heading")?></h1>

<?php
$floor = NULL;
$columns = 3;
$currentCol = -1;
?>

<div id="orderby">
  <span><?php echo link_to(__('resident.list.orderByRoom'), 'resident_listByRoom') ?></span>
  <span><?php echo link_to(__('resident.list.orderByLastName'), 'resident_listByLastName') ?></span>
  <span><?php echo link_to(__('resident.list.orderByMoveIn'), 'resident_listByMoveIn') ?></span>
</div>
<?php foreach ($residents as $resident):
             $roomNo = str_pad($resident['Rooms']['room_no'], 3, "0", STR_PAD_LEFT);?>
  <?php if (substr($roomNo, 0, 1) != $floor):
          $floor = substr($roomNo, 0, 1);
          ++$currentCol ?>
<table style="float:left; margin-bottom: 3em; margin-right:2em; <?php if( $currentCol%$columns == 0) echo "clear:left;"; ?>">
  <thead>
    <tr>
      <th colspan="3"><?php echo substr($roomNo, 0, 1) . '. ' . __("resident.list.floor") ?></th>
    </tr>
    <tr>
      <th><?php echo __("resident.roomNo") ?></th>
      <th><?php echo __("resident.lastName") ?></th>
      <th><?php echo __("resident.firstName")?></th>
    </tr>
  </thead>
  <tbody>
  <?php endif; ?>
    <tr class="<?php echo (! $resident->getUnlocked()) ? 'locked' : 'unlocked' ?>">
      <td><a href="<?php echo url_for('@resident_edit?id='.$resident->getId()) ?>"><?php echo $roomNo ?></a></td>
      <td><?php echo $resident->getLastName() ?></td>
      <td><?php echo $resident->getFirstName() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
