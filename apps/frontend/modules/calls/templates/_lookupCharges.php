<?php use_javascript('jquery-lookup_charges.js') ?>

<div class="lookup-charges">
  <h2><?php echo __("calls.charges.heading") ?></h2>
  <form action="<?php echo url_for('lookup_charges') ?>" method="get">
    <input type="text" name="destination" value="<?php echo $sf_request->getParameter('destination') ?>" id="destination" />
    <input type="submit" id="submit" value="<?php echo __('calls.charges.get')?>" />
    <img id="loader" src="/images/loader.gif" style="vertical-align: middle; display: none; margin: 0; padding: 0; width: 1em; height: auto" />
    <div class="help">
      <?php echo __('calls.charges.help')?>
    </div>
    <span id="charges"><?php echo $sf_request->getParameter('charges')?></span>
  </form>
</div>
