<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    DEFINE('ASTERISK_PARAMETER_SEPARATOR', ',');

    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfDoctrineDynamicFormRelationsPlugin');

    // usergroup of the linux system which gets access to the dtaus-files
    sfConfig::set('usergroup', 'hekphone');

    // These parameters are used for creating the dtaus-file (*.ctl) when the bills are generated
    sfConfig::set('transactionName', 'RECHNUNG HEK-PHONE');
    sfConfig::set('hekphoneName', 'HEK-PHONE');
    sfConfig::set('hekphoneAccountnumber', '123123123');
    sfConfig::set('hekphoneBanknumber', '123123123');

    sfConfig::set('hekphoneFromEmailAdress', 'telefon@hek.uni-karlsruhe.de');

    // As soon as a residents current bill amount comes closer to the bill limit (default: 75)
    // two warnings are sent via email. The first, when the bill amount reaches "billLimitFirstThreshold" [0..1]
    // of the limit. The second, when it reached "billLimitSecondThreshold".
    sfConfig::set('billLimitFirstThreshold', 0.75);
    sfConfig::set('billLimitSecondThreshold', 0.9);

    // These parameters are used in asterisk and are needed for billing purposes
    sfConfig::set('asteriskUnlockedPhonesContexts', array('anlage', 'unlocked')); // contexts of phones that are allowed to make external calls
    sfConfig::set('asteriskIncomingContext', 'amt');                              // context of incoming calls
    sfConfig::set('asteriskInternalUserfield', 'internal');                       // userfield of internal calls is set to this

    // Rooms where every resident can enter and do calls (common rooms, media room, bar, ...)
    // These rooms are only allowed to place free calls.
    sfConfig::set('hekphonePublicRooms', array('000'));

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
