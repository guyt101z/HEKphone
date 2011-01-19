<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <?php if ($sf_user->isAuthenticated()): echo "\n";?>
    <div id="navigation">
      <ul id="globalnav">
        <li><?php echo link_to(__('navigation.calls'), 'calls') ?></li>
        <li><?php echo link_to(__('navigation.vm'), 'vm') ?></li>
        <li><?php echo link_to(__('navigation.settings'), 'settings') ?></li>
        <?php if ($sf_user->hasCredential('hekphone')): echo "\n"; ?>
        <li class="adminnav"><?php echo link_to(__('navigation.residents'), 'resident_list') ?></li>
        <li class="adminnav"><?php echo link_to(__('navigation.phones'), 'phone/index') ?></li>
        <li class="adminnav"><?php echo link_to(__('navigation.tasks'), 'tasks/index') ?></li>
        <li class="adminnav"><?php echo link_to(__('navigation.groupcalls'), 'groupcalls/index') ?></li>
        <?php endif;?>

        <li><?php echo link_to(__('navigation.logout'), 'auth/logout') ?></li>
      </ul>
      <?php if ($sf_request->hasParameter('residentid')): echo "\n"; ?>
      <ul id="residentnav">
        <li><?php echo link_to(__('navigation.resident.edit'), 'resident_edit', array('residentid' => $sf_request->getParameter('residentid'))) ?></li>
        <li><?php echo link_to(__('navigation.resident.phone'), 'resident_phone', array('residentid' => $sf_request->getParameter('residentid'))) ?></li>
        <li><?php echo link_to(__('navigation.resident.calls'), 'resident_calls', array('residentid' => $sf_request->getParameter('residentid'))) ?></li>
        <li><?php echo link_to(__('navigation.resident.vm'), 'resident_vm', array('residentid' => $sf_request->getParameter('residentid'))) ?></li>
        <li><?php echo link_to(__('navigation.resident.settings'), 'resident_settings', array('residentid' => $sf_request->getParameter('residentid'))) ?></li>
      </ul>
      <?php endif;?>

    </div>
    <?php endif;?>
    <?php echo $sf_content ?>
  </body>
</html>
