<?php

class hekphoneUpdatebanksTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),

      new sfCommandOption('install', null, sfCommandOption::PARAMETER_NONE, 'Install the database structure for BAV'),
    ));

    $this->namespace        = 'hekphone';
    $this->name             = 'update-banks';
    $this->briefDescription = 'Writes new bank codes from the Bundesbank website to the database';
    $this->detailedDescription = <<<EOF
The [hekphone:update-banks|INFO] task does things.
Call it with:

  [php symfony hekphone:update-banks|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    if($options['install']) {
        Doctrine_Core::getTable('Banks')->install();
    }
    Doctrine_Core::getTable('Banks')->updateData();
  }
}
