<?php

class hekphoneCheckresidentsmovinginTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),

      new sfCommandOption('prepare-phone', null, sfCommandOption::PARAMETER_NONE, 'Prepare phone for the new residents'),
      new sfCommandOption('silent', null, sfCommandOption::PARAMETER_NONE, 'Suppress logging to stdout.'),
    ));

    // Prepare rendering of partials (load the PartialHelper)
    $configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
    sfContext::createInstance($configuration);
    sfProjectConfiguration::getActive()->loadHelpers("Partial");

    $this->namespace        = 'hekphone';
    $this->name             = 'check-residents-moving-in';
    $this->briefDescription = 'Check ';
    $this->detailedDescription = <<<EOF
The [hekphone:check-residents-moving-in|INFO] task checks which residents move in today and prepares the phone in the room
with the residents details.

If called withoud parameters it prints a list of all residents moving in today.
Call it with:

  [php symfony hekphone:check-residents-moving-in|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $logger = new sfAggregateLogger($this->dispatcher);
    $logger->addLogger(new sfFileLogger($this->dispatcher, array('file' => $this->configuration->getRootDir() . '/log/cron-move_in.log')));
    if( ! $options['silent']) {
        $logger->addLogger(new sfCommandLogger($this->dispatcher));
    }

    $residentsMovingInToday = Doctrine_Core::getTable('Residents')->findResidentsMovingInToday();
    $logger->info("There are " . count($residentsMovingInToday) . " Residents moving in today.");

    if($options["prepare-phone"]){
        foreach($residentsMovingInToday as $resident){
            // Get the phone if there's any
            if ( ! $resident['Rooms']->relatedExists('Phones')) {
                $logger->err("No phone in room of resident " . $resident->getId() . ": " . $resident . ".");

                continue;
            } else {
                $phone = Doctrine_Core::getTable('Phones')->findOneById($resident['Rooms']->phone);
            }

            // Reset phone and thereby transfer the users information to the phone
            if($phone->get('technology') == 'SIP') {
                try {
                    $phone->resetConfiguration(true);
                    $phone->pruneAsteriskPeer();

                    $logger->notice("Prepared phone for resident " . $resident);
                } catch (Exception $e) {
                    $logger->err("Preparing the phone of resident " . $resident . " failed: " . $e->getMessage());
                }
            }
        }
    }
  }
}
