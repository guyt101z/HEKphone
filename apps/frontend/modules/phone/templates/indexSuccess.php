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
      <th>Mailbox</th>
      <th>Technology</th>
      <th>Ipaddr</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($phones as $phone): ?>
    <tr>
      <td><a href="<?php echo url_for('phone/edit?id='.$phone->getId()) ?>"><?php echo $phone->getName() ?></a></td>
      <td><?php echo $phone->getType() ?></td>
      <td><?php echo $phone->getCallerid() ?></td>
      <td><?php echo $phone->getHost() ?></td>
      <td><?php echo $phone->getDefaultip() ?></td>
      <td><?php echo $phone->getMac() ?></td>
      <td><?php echo $phone->getMailbox() ?></td>
      <td><?php echo $phone->getTechnology() ?></td>
      <td><?php echo $phone->getIpaddr() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('phone/new') ?>"><?php echo __('phone.new') ?></a>
