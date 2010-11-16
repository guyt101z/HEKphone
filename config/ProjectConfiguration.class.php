<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfDoctrineDynamicFormRelationsPlugin');
    
    //These parameters are used for creating the dtaus-file (*.ctl) when the bills are generated
    sfConfig::set("TransactionName", "RECHNUNG HEK-PHONE");
    sfConfig::set("myName", "HEK-PHONE");
    sfConfig::set("myAccountnumber", "105010993");
    sfConfig::set("myBanknumber", "52060410");
   
  }
}
