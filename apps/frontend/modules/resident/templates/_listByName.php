<?php
$firstLetter = '';
?>

<?php foreach ($residents as $resident):
        $roomNo = str_pad($resident['Rooms']['room_no'], 3, "0", STR_PAD_LEFT);
        if (substr($resident->last_name, 0, 1) != $firstLetter):
          $firstLetter = substr($resident->last_name, 0, 1);
?>
<table style="margin-bottom: 3em; margin-right:2em;">
  <thead>
    <tr>
      <th colspan="3"><?php echo $firstLetter ?></th>
    </tr>
    <tr>
      <th><?php echo __("resident.room_no") ?></th>
      <th><?php echo __("resident.last_name") ?></th>
      <th><?php echo __("resident.first_name")?></th>
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