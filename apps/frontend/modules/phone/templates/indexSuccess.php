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
      <th>Regserver</th>
      <th>Regseconds</th>
      <th>Ipaddr</th>
      <th>Port</th>
      <th>Fullcontact</th>
      <th>Useragent</th>
      <th>Lastms</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($phoness as $phones): ?>
    <tr>
      <td><a href="<?php echo url_for('phone/edit?id='.$phones->getId()) ?>"><?php echo $phones->getId() ?></a></td>
      <td><?php echo $phones->getName() ?></td>
      <td><?php echo $phones->getType() ?></td>
      <td><?php echo $phones->getCallerid() ?></td>
      <td><?php echo $phones->getSecret() ?></td>
      <td><?php echo $phones->getHost() ?></td>
      <td><?php echo $phones->getDefaultip() ?></td>
      <td><?php echo $phones->getMac() ?></td>
      <td><?php echo $phones->getLanguage() ?></td>
      <td><?php echo $phones->getMailbox() ?></td>
      <td><?php echo $phones->getDefaultuser() ?></td>
      <td><?php echo $phones->getRegserver() ?></td>
      <td><?php echo $phones->getRegseconds() ?></td>
      <td><?php echo $phones->getIpaddr() ?></td>
      <td><?php echo $phones->getPort() ?></td>
      <td><?php echo $phones->getFullcontact() ?></td>
      <td><?php echo $phones->getUseragent() ?></td>
      <td><?php echo $phones->getLastms() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('phone/new') ?>">New</a>
