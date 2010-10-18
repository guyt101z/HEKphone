<h1><?php echo __("resident.list.heading")?></h1>

<div id="orderby">
  <span><?php echo link_to(__('resident.list.orderByRoom'), 'resident_listByRoom') ?></span>
  <span><?php echo link_to(__('resident.list.orderByLastName'), 'resident_listByLastName') ?></span>
  <span><?php echo link_to(__('resident.list.orderByMoveIn'), 'resident_listByMoveIn') ?></span>
</div>

<?php
switch ($sf_request->getParameter('orderby'))
{
  case 'room':
    include_partial('listByRoom', array('residents' => $residents));
    break;
  case 'name':
    include_partial('listByName', array('residents' => $residents));
    break;
  case 'move_in':
    include_partial('listByMoveIn', array('residents' => $residents));
    break;
  default:
    include_partial('listByRoom', array('residents' => $residents));
}

?>
