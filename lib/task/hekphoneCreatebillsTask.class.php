<?php

class hekphoneCreatebillsTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'hekphone'),
      new sfCommandOption('start', null, sfCommandOption::PARAMETER_OPTIONAL, 'Start date of bills'),
      new sfCommandOption('end', null, sfCommandOption::PARAMETER_OPTIONAL, 'End date of bills')
      // add your own options here
    ));
//TODO
    $this->namespace        = 'hekphone';
    $this->name             = 'create-bills';
    $this->briefDescription = 'Creates bills for residents for a given time period [default:last month]';
    $this->detailedDescription = <<<EOF
The [hekphone:create-bills|INFO] creates for all unbilled calls in a given time period a bill for the dedicated user. 
Furthermore it creates an itemised Bill and sends it via mail to the resident.
Call it with:

  [php symfony hekphone:create-bills|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $billsTable = Doctrine_Core::getTable('Bills');
    
    
    if ($billsTable->createBills(array("start" => $options['start'], "end" => $options['end'])))
    {  
    	
        $this->log($this->formatter->format("Bills succesfully created", 'INFO'));	
        
        
    }
    
 

    
    
  }
}
