<?php

class hekphoneCreatedtausTask extends sfBaseTask
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
      new sfCommandOption('billDate', null, sfCommandOption::PARAMETER_REQUIRED, 'End date of bills')
      
      // add your own options here
    ));

    $this->namespace        = 'hekphone';
    $this->name             = 'create-dtaus';
    $this->briefDescription = 'Creates the dtaus files for existing bills';
    $this->detailedDescription = <<<EOF
The [hekphone:create-dtaus|INFO] creates only the dtaus files according to existing bills of a specific date. 
Call it with:

  [php symfony hekphone:create-dtaus|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    if (isset($options['billDate']))
    {
	    $bills = Doctrine_Query::create()
	                          ->from('Bills')
	                          ->addWhere('date = ?', $options['billDate'])
	                          ->execute();
	    $billsCollection = new BillsCollection('Bills');
	       
	    foreach ($bills as $bill)
	    {
	        $billsCollection->add($bill, $bill['id']);              
	    }
	    $billsCollection->save();
	    $billsCollection->createDtausFiles();
    }   
    else 
    {
        echo 'Parameter billDate has to be set!' . PHP_EOL;	
    }
        
    
  }
}
