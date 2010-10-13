<b>Hallo <?php echo $sf_user->getAttribute('name')  ?>!</b>

<?php if ($sf_user->hasFlash('notice')): ?>
<div class="flash">
<?php echo $sf_user->getFlash('notice') ?>
</div>
<?php endif; ?>