<h1><?php echo __('phone.list.title') ?></h1>

<table class="list">
  <thead>
    <tr>
      <th>Name</th>
      <th>Type</th>
      <th>Callerid</th>
      <th>Host</th>
      <th>Defaultip</th>
      <th>Mac</th>
      <th>Technology</th>
      <th>Ipaddr</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($phones as $phone): ?>
    <tr>
      <td><a href="<?php echo url_for('phone_edit', array('id' => $phone->getId())) ?>"><?php echo $phone->getName() ?></a></td>
      <td><a href="<?php echo url_for('phone_edit', array('id' => $phone->getId())) ?>"><?php echo $phone->getType() ?></a></td>
      <td><a href="<?php echo url_for('phone_edit', array('id' => $phone->getId())) ?>"><?php echo $phone->getCallerid() ?></a></td>
      <td><a href="<?php echo url_for('phone_edit', array('id' => $phone->getId())) ?>"><?php echo $phone->getHost() ?></a></td>
      <td><a href="<?php echo url_for('phone_edit', array('id' => $phone->getId())) ?>"><?php echo $phone->getDefaultip() ?></a></td>
      <td><a href="<?php echo url_for('phone_edit', array('id' => $phone->getId())) ?>"><?php echo $phone->getMac() ?></a></td>
      <td><a href="<?php echo url_for('phone_edit', array('id' => $phone->getId())) ?>"><?php echo $phone->getTechnology() ?></a></td>
      <td><a href="<?php echo url_for('phone_edit', array('id' => $phone->getId())) ?>"><?php echo $phone->getIpaddr() ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('phone_new') ?>"><?php echo __('phone.new') ?></a>
