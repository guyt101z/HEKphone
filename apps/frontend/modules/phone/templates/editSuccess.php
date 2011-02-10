<h1><?php echo __('phone.edit.title') ?></h1>

<?php include_partial('form', array('form' => $form)) ?>

<h3>Aktionen</h3>
<ul>
  <li><?php echo link_to(__('phone.edit.reset.keepPersonalSettings'), 'phone/reset?id=' . $form->getObject()->getId(),
    array('query_string' => 'overwritePersonalSettings=false',
        'confirm' => __('phone.edit.reset.warning.keeping_personal_settings'))) ?> <br />
  </li>
  <li><?php echo link_to(__('phone.edit.reset.overwritePersonalSettings'), 'phone/reset?id=' . $form->getObject()->getId(),
    array('query_string' => 'overwritePersonalSettings=true',
        'confirm' => __('phone.edit.reset.warning.overwrite_personal_settings'))) ?>
  </li>
  <li><?php echo link_to(__('phone.edit.reset.initialConfiguration'), 'phone/reset?id=' . $form->getObject()->getId(),
    array('query_string' => 'initialConfiguration=true&overwritePersonalSettings=true',
        'confirm' => __('phone.edit.reset.warning.initial_configuration'))) ?>
  </li>
</ul>
