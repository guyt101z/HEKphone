<?php

class hekphoneDeleteoldcdrsTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));
    $this->addOptions(array(
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The database connection name', 'hekphone'),
      new sfCommandOption('months', null, sfCommandOption::PARAMETER_REQUIRED, 'Delete the data from how many preceeding months?'),
    ));

    $this->namespace        = 'hekphone';
    $this->name             = 'delete-old-cdrs';
    $this->briefDescription = 'Deletes all cdrs and calls which are older than some months [default:three months]';
    $this->detailedDescription = <<<EOF
The [hekphone:delete-old-cdrs|INFO] task does things.
Call it with:

  [php symfony hekphone:delete-old-cdrs|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // determine how many months to delete
    if ($options['months'])
    {
        $months = $options['months'];
    }
    else
    {
        $months = 3;
    }


  }
}
