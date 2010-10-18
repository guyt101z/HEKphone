<h1>Phoness List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Accountcode</th>
      <th>Callerid</th>
      <th>Canreinvite</th>
      <th>Host</th>
      <th>Port</th>
      <th>Mailbox</th>
      <th>Md5secret</th>
      <th>Nat</th>
      <th>Permit</th>
      <th>Deny</th>
      <th>Mask</th>
      <th>Qualify</th>
      <th>Secret</th>
      <th>Type</th>
      <th>Username</th>
      <th>Defaultuser</th>
      <th>Useragent</th>
      <th>Fromuser</th>
      <th>Fromdomain</th>
      <th>Disallow</th>
      <th>Allow</th>
      <th>Ipaddr</th>
      <th>Mac</th>
      <th>Fullcontact</th>
      <th>Regexten</th>
      <th>Regserver</th>
      <th>Regseconds</th>
      <th>Lastms</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($phoness as $phones): ?>
    <tr>
      <td><a href="<?php echo url_for('phone/edit?id='.$phones->getId()) ?>"><?php echo $phones->getId() ?></a></td>
      <td><?php echo $phones->getName() ?></td>
      <td><?php echo $phones->getAccountcode() ?></td>
      <td><?php echo $phones->getCallerid() ?></td>
      <td><?php echo $phones->getCanreinvite() ?></td>
      <td><?php echo $phones->getHost() ?></td>
      <td><?php echo $phones->getPort() ?></td>
      <td><?php echo $phones->getMailbox() ?></td>
      <td><?php echo $phones->getMd5secret() ?></td>
      <td><?php echo $phones->getNat() ?></td>
      <td><?php echo $phones->getPermit() ?></td>
      <td><?php echo $phones->getDeny() ?></td>
      <td><?php echo $phones->getMask() ?></td>
      <td><?php echo $phones->getQualify() ?></td>
      <td><?php echo $phones->getSecret() ?></td>
      <td><?php echo $phones->getType() ?></td>
      <td><?php echo $phones->getUsername() ?></td>
      <td><?php echo $phones->getDefaultuser() ?></td>
      <td><?php echo $phones->getUseragent() ?></td>
      <td><?php echo $phones->getFromuser() ?></td>
      <td><?php echo $phones->getFromdomain() ?></td>
      <td><?php echo $phones->getDisallow() ?></td>
      <td><?php echo $phones->getAllow() ?></td>
      <td><?php echo $phones->getIpaddr() ?></td>
      <td><?php echo $phones->getMac() ?></td>
      <td><?php echo $phones->getFullcontact() ?></td>
      <td><?php echo $phones->getRegexten() ?></td>
      <td><?php echo $phones->getRegserver() ?></td>
      <td><?php echo $phones->getRegseconds() ?></td>
      <td><?php echo $phones->getLastms() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('phone/new') ?>">New</a>
