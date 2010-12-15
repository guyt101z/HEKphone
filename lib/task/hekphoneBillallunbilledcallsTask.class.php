<?php

class hekphoneBillallunbilledcallsTask extends sfBaseTask
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
    ));

    $this->namespace        = 'hekphone';
    $this->name             = 'bill-all-unbilled-calls';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [hekphone:bill-all-unbilled-calls|INFO] task does things.
Call it with:

  [php symfony hekphone:bill-all-unbilled-calls|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $collCdr  = Doctrine_Query::create()
              ->from('AsteriskCdr')
              ->where('billed = ?', false)
              ->addWhere('dcontext = ? ', 'anlage')
              ->limit(50)
              ->execute();

    if ( ! $collCdr)
       throw new sfCommandException("A call with uniqueid=".$arguments['uniqueid']." is not present in asterisk_cdr");

    foreach($collCdr as $cdr)
    {
        $cdr->bill();
    }
  }
}
