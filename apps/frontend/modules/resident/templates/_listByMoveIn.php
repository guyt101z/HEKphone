<?php
$floor = NULL;
$columns = 3;
$currentCol = -1;
?>


<table>
  <thead>
    <tr>
      <th><?php echo __("resident.move_in") ?></th>
      <th><?php echo __("resident.last_name") ?></th>
      <th><?php echo __("resident.first_name")?></th>
      <th><?php echo __("resident.room_no") ?></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($residents as $resident): ?>
    <tr class="<?php echo (! $resident->getUnlocked()) ? 'locked' : 'unlocked' ?>">
      <td><a href="<?php echo url_for('@resident_edit?residentid='.$resident->getId()) ?>"><?php echo $resident->getMoveIn() ?></a></td>
      <td><a href="<?php echo url_for('@resident_edit?residentid='.$resident->getId()) ?>"><?php echo $resident->getLastName() ?></a></td>
      <td><a href="<?php echo url_for('@resident_edit?residentid='.$resident->getId()) ?>"><?php echo $resident->getFirstName() ?></a></td>
      <td><a href="<?php echo url_for('@resident_edit?residentid='.$resident->getId()) ?>"><?php echo str_pad($resident['Rooms']['room_no'], 3, "0", STR_PAD_LEFT);  ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>