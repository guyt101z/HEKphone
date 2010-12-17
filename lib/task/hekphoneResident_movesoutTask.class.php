<?php

class hekphoneResident_movesoutTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'hekphone'),
      // add your own options here
      new sfCommandOption('mail', null, sfCommandOption::PARAMETER_OPTIONAL, 'Resident gets an informational email'),
      new sfCommandOption('lock', null, sfCommandOption::PARAMETER_OPTIONAL, 'All residents who move out today get locked')
    ));

    $this->namespace        = 'hekphone';
    $this->name             = 'resident_movesout';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [hekphone:resident_movesout|INFO] task does things.
Call it with:

  [php symfony hekphone:resident_movesout|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here
    $date_tomorrow = date("Y-m-d", strtotime("+1 day", strtotime(date("Y-m-d"))));
    $residentsMovingOutTomorrow = Doctrine_Query::create()
        ->from('Residents')
        ->where('move_out = ?', $date_tomorrow)
        ->execute();
     
    
    foreach ($residentsMovingOutTomorrow as $resident)
    {
        $resident->sendLockEmail();
    }
    
    
  }
}
