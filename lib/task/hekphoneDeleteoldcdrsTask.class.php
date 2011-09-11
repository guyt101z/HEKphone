<?php

class hekphoneDeleteoldcdrsTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),

      new sfCommandOption('silent', null, sfCommandOption::PARAMETER_NONE, 'Suppress logging to stdout. '),
    ));

    $this->namespace        = 'hekphone';
    $this->name             = 'delete-old-cdrs';
    $this->briefDescription = 'Deletes all cdrs and calls which are older than some months [default:three months]';
    $this->detailedDescription = <<<EOF
The [hekphone:delete-old-cdrs|INFO] task deletes calls, cdrs and bills older than specified in the ProjectConfiguration.
Look for the variables monthsToKeepCdrsFor (same for calls and cdrs) and monthsToKeepBillsFor.
Call it with:

  [php symfony hekphone:delete-old-cdrs|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $logger = new sfAggregateLogger($this->dispatcher);
    $logger->addLogger(new sfFileLogger($this->dispatcher, array('file' => $this->configuration->getRootDir() . '/log/cron-delete_old_cdrs.log')));
    if( ! $options['silent']) {
        $logger->addLogger(new sfCommandLogger($this->dispatcher));
    }

    Doctrine_Core::getTable('Calls')->deleteOldCalls();
    Doctrine_Core::getTable('AsteriskCdr')->deleteOldCdrs();
    Doctrine_Core::getTable('Bills')->deleteOldBills();

    $logger->notice('Cleared old calls, cdrs and bills.');
  }
}
