<?php

class hekphoneResident_movesoutTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'hekphone'),

      new sfCommandOption('mail', null, sfCommandOption::PARAMETER_OPTIONAL, 'Resident gets an informational email'),
      new sfCommandOption('lock', null, sfCommandOption::PARAMETER_OPTIONAL, 'All residents who move out today get locked')
    ));

    $this->namespace        = 'hekphone';
    $this->name             = 'check-residents-moving-out';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [hekphone:check-residents-moving-out|INFO] fetches all users moving out tomorrow. Sends a goodbye-email
to them and locks them.
Call it with:

  [php symfony hekphone:check-residents-moving-out|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $residentsMovingOutTomorrow = Doctrine_Core::getTable('Residents')->findResidentsMovingOutTomorrow();

    foreach ($residentsMovingOutTomorrow as $resident)
    {
        if($options['mail'])
        {
            $resident->sendLockEmail();
        }
    }

    $residentsMovingOutToday = Doctrine_Core::getTable('Residents')->findResidentsMovingOutToday();
    foreach ($residentsMovingOutToday as $resident)
    {
        if($options['lock'])
        {
            $resident->setUnlocked('false');
        }
    }


  }
}
