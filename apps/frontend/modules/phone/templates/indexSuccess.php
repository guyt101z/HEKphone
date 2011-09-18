<h1><?php echo __('phone.list.title') ?></h1>

<table class="list">
  <thead>
    <tr>
      <th title="<?php echo __('phone.list.heading.peername.help') ?>">
        <?php echo __('phone.list.heading.peername') ?>
      </th>
      <th title="<?php echo __('phone.list.heading.defaultip.help') ?>">
        <?php echo __('phone.list.heading.defaultip') ?>
      </th>
      <th title="<?php echo __('phone.list.heading.mac.help') ?>">
        <?php echo __('phone.list.heading.mac') ?>
      </th>
      <th title="<?php echo __('phone.list.heading.technology.help') ?>">
        <?php echo __('phone.list.heading.technology') ?>
      </th>
      <th title="<?php echo __('phone.list.heading.ipaddr.help') ?>">
        <?php echo __('phone.list.heading.ipaddr') ?>
      </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($phones as $phone): ?>
    <tr>
      <td><a href="<?php echo url_for('phone_edit', array('id' => $phone->getId())) ?>"><?php echo $phone->getName() ?></a></td>
      <td><a href="<?php echo url_for('phone_edit', array('id' => $phone->getId())) ?>"><?php echo $phone->getDefaultip() ?></a></td>
      <td><a href="<?php echo url_for('phone_edit', array('id' => $phone->getId())) ?>"><?php echo $phone->getMac() ?></a></td>
      <td><a href="<?php echo url_for('phone_edit', array('id' => $phone->getId())) ?>"><?php echo $phone->getTechnology() ?></a></td>
      <td><a href="<?php echo url_for('phone_edit', array('id' => $phone->getId())) ?>"><?php echo $phone->getIpaddr() ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('phone_new') ?>"><?php echo __('phone.new') ?></a>
