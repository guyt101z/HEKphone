<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfDoctrineDynamicFormRelationsPlugin');

    // usergroup of the linux system which gets access to the dtaus-files
    sfConfig::set('usergroup', 'hekphone');

    // These parameters are used for creating the dtaus-file (*.ctl) when the bills are generated
    sfConfig::set('transactionName', 'RECHNUNG HEK-PHONE');
    sfConfig::set('hekphoneName', 'HEK-PHONE');
    sfConfig::set('hekphoneAccountnumber', '111111111');
    sfConfig::set('hekphoneBanknumber', '52060410');

    // These parameters are used in asterisk and are needed for billing purposes
    sfConfig::set('asteriskUnlockedPhonesContexts', array('anlage', 'unlocked')); // contexts of phones that are allowed to make external calls
    sfConfig::set('asteriskIncomingContext', 'amt'); // contexts of phones that are allowed to make external calls
  }
}
