<!DOCTYPE html>
<!--[if lt IE 9 ]> <html class="ie"> <![endif]-->
<html>
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <div id="container">
    <?php if ($sf_user->isAuthenticated()): echo "\n";?>
        <header>
        <nav>
          <ul id="globalnav">
            <?php //FIXME: the way we're highlighting the current navigation item is ugly. use slots/components ?>
            <li <?php echo ($this->getModuleName() == 'calls') ? 'class="current"' : '';?>><?php echo link_to(__('navigation.calls'), 'calls') ?></li>
            <li <?php echo ($this->getModuleName() == 'voicemail') ? 'class="current"' : '';?>><?php echo link_to(__('navigation.voicemail'), 'voicemail') ?></li>
            <li <?php echo ($this->getModuleName() == 'settings') ? 'class="current"' : '';?>><?php echo link_to(__('navigation.settings'), 'settings') ?></li>
            <?php if ($sf_user->hasCredential('hekphone')): echo "\n"; ?>
            <li class="<?php echo ($this->getModuleName() == 'resident') ? 'current ' : '';?>adminnav"><?php echo link_to(__('navigation.residents'), 'resident_list') ?></li>
            <li class="<?php echo ($this->getModuleName() == 'phone') ? 'current ' : '';?>adminnav"><?php echo link_to(__('navigation.phones'), 'phone/index') ?></li>
            <li class="<?php echo ($this->getModuleName() == 'tasks') ? 'current ' : '';?>adminnav"><?php echo link_to(__('navigation.tasks'), 'tasks/index') ?></li>
            <li class="<?php echo ($this->getModuleName() == 'groupcalls') ? 'current ' : '';?>adminnav"><?php echo link_to(__('navigation.groupcalls'), 'groupcalls/index') ?></li>
            <?php endif;?>
            <li <?php echo ($this->getModuleName() == 'auth') ? 'class="current"' : '';?>><?php echo link_to(__('navigation.logout'), 'auth/logout') ?></li>
          </ul>
          <?php if ($sf_request->hasParameter('residentid') && $sf_user->hasCredential('hekphone')): echo "\n"; ?>
          <ul id="residentnav">
            <li><span>Bewohner bearbeiten:</span></li>
            <li><?php echo link_to(__('navigation.resident.edit'), 'resident_edit', array('residentid' => $sf_request->getParameter('residentid'))) ?></li>
            <li><?php echo link_to(__('navigation.resident.phone'), 'resident_phone', array('residentid' => $sf_request->getParameter('residentid'))) ?></li>
            <li><?php echo link_to(__('navigation.resident.calls'), 'resident_calls', array('residentid' => $sf_request->getParameter('residentid'))) ?></li>
            <li><?php echo link_to(__('navigation.resident.voicemail'), 'resident_voicemail', array('residentid' => $sf_request->getParameter('residentid'))) ?></li>
            <li><?php echo link_to(__('navigation.resident.settings'), 'resident_settings', array('residentid' => $sf_request->getParameter('residentid'))) ?></li>
          </ul>
          <?php endif;?>

        </nav>
      </header>
      <?php endif;?>
      <?php if ($sf_user->hasFlash('notice')): ?>
      <div class="notice">
        <?php echo __($sf_user->getFlash('notice')) ?>
      </div>
      <?php endif;?>
      <?php if ($sf_user->hasFlash('error')): ?>
      <div class="error">
        <?php echo __($sf_user->getFlash('error')) ?>
      </div>
      <?php endif;?>

      <?php echo $sf_content ?>
    </div>
  </body>
</html>
