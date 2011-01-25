<h1>Edit Phones</h1>

<?php if ($sf_user->hasFlash('notice')): ?>
<div class="notice">
<?php echo $sf_user->getFlash('notice') ?>
</div>
<?php endif;?>

<?php if ($sf_user->hasFlash('error')): ?>
<div class="error">
<?php echo $sf_user->getFlash('error') ?>
</div>
<?php endif;?>

<?php include_partial('form', array('form' => $form)) ?>

<?php echo link_to('Reset Phone (keep users settings)', 'phone/reset?id=' . $form->getObject()->getId(),
    array('overwritePersonalSettings' => false,
        'method' => 'reset',
        'confirm' => 'The phone will reboot. Are you sure?')) ?> <br />
<?php echo link_to('Reset Phone (completely)', 'phone/reset?id=' . $form->getObject()->getId(),
    array('id' => $form->getObject()->getId(),
        'overwritePersonalSettings' => false,
        'method' => 'reset',
        'confirm' => 'The phone will reboot and personal data like phone book, shortdial,.. will belost.. Are you sure?')) ?>

