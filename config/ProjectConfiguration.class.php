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

    sfConfig::set('hekphoneFromEmailAdress', 'telefon@hek.uni-karlsruhe.de');

    // These parameters are used in asterisk and are needed for billing purposes
    sfConfig::set('asteriskUnlockedPhonesContexts', array('anlage', 'unlocked')); // contexts of phones that are allowed to make external calls
    sfConfig::set('asteriskIncomingContext', 'amt'); // contexts of phones that are allowed to make external calls

    // Privacy settings delete cdrs and bills after a specific period of time. Affects the task hekphone:delete-old-cdrs
    // which should be run periodically via cronjob
    sfConfig::set('monthsToKeepCdrsFor',  3);
    sfConfig::set('monthsToKeepBillsFor', 6);

    // Ugly workaround for bug DC-740:
    // http://www.doctrine-project.org/jira/browse/DC-740
    // took half a day to figure this out...
    $this->dispatcher->connect('doctrine.configure', array($this, 'doctrineBinder'));
  }

  public function doctrineBinder(sfEvent $event)
  {
    $manager = Doctrine_Manager::getInstance();
    $manager->bindComponent('HekdbCurrentResidents', 'hekdb');
  }

}
