<h1>Phoness List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Type</th>
      <th>Callerid</th>
      <th>Secret</th>
      <th>Host</th>
      <th>Defaultip</th>
      <th>Mac</th>
      <th>Language</th>
      <th>Mailbox</th>
      <th>Defaultuser</th>
      <th>current Ipaddr</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($phones as $phone): ?>
    <tr>
      <td><a href="<?php echo url_for('phone/edit?id='.$phone->getId()) ?>"><?php echo $phone->getId() ?></a></td>
      <td><?php echo $phone->getName() ?></td>
      <td><?php echo $phone->getType() ?></td>
      <td><?php echo $phone->getCallerid() ?></td>
      <td><?php echo $phone->getSecret() ?></td>
      <td><?php echo $phone->getHost() ?></td>
      <td><?php echo $phone->getDefaultip() ?></td>
      <td><?php echo $phone->getMac() ?></td>
      <td><?php echo $phone->getLanguage() ?></td>
      <td><?php echo $phone->getMailbox() ?></td>
      <td><?php echo $phone->getDefaultuser() ?></td>
      <td><?php echo $phone->getIpaddr() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('phone/new') ?>">New</a>
