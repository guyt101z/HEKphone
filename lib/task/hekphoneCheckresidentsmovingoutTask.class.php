<?php

class hekphoneCheckresidentsmovingoutTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),

      new sfCommandOption('warn-resident', null, sfCommandOption::PARAMETER_NONE, 'Residents who move out tomorrow get an informational email'),
      new sfCommandOption('lock', null, sfCommandOption::PARAMETER_NONE, 'All residents who move out today get locked'),
      new sfCommandOption('reset-phone', null, sfCommandOption::PARAMETER_NONE, 'Reset phones details '),
      new sfCommandOption('notify-team', null, sfCommandOption::PARAMETER_NONE, 'The hekphone team gets a summary of who\'s moving out.'),

      new sfCommandOption('silent', null, sfCommandOption::PARAMETER_NONE, 'Supress informative output, only print errors.')
    ));

    // Prepare rendering of partials (load the PartialHelper)
    $configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
    sfContext::createInstance($configuration);
    sfProjectConfiguration::getActive()->loadHelpers("Partial");

    $this->namespace        = 'hekphone';
    $this->name             = 'check-residents-moving-out';
    $this->briefDescription = 'Locks/Warns residents moving out today or tomorrow';
    $this->detailedDescription = <<<EOF
The [hekphone:check-residents-moving-out|INFO] fetches all unlocked users moving out tomorrow. Sends a goodbye-email
to them and locks them.
If called withoud parameters it prints a list of all residents moving out today and tomorrow.
Call it with:

  [php symfony hekphone:check-residents-moving-out|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    /* Notify residents that they are going to be locked tomorrow */
    $residentsMovingOutTomorrow = Doctrine_Core::getTable('Residents')->findResidentsMovingOutTomorrow();
    $residentsMovingOutToday = Doctrine_Core::getTable('Residents')->findResidentsMovingOutToday();
    $residentsMovingOutYesterday = Doctrine_Core::getTable('Residents')->findResidentsMovingOutYesterday();

    if($options['warn-resident']) {
        foreach ($residentsMovingOutTomorrow as $resident)
        {
            $resident->sendLockEmail(date('Y-m-d'));
        }
    }

    /* Lock residents who moved out yesterday */
    if($options['lock'])
    {
        foreach($residentsMovingOutYesterday as $resident)
        {
            $resident->setUnlocked('false');
            $resident->save();
        }
    }

    /* Reset the phone of these residents */
    if($options['reset-phone']) {
        foreach($residentsMovingOutYesterday as $resident) {
            // get the phone if there's any
            if ( $resident['Rooms']->phone == NULL ) {
                $resetSuccessful[$resident->get('id')] = false;
                continue;
            } else {
                $phone = Doctrine_Core::getTable('Phones')->findOneById($resident['Rooms']->phone);
            }

            // Delete personal information from the phones properties (not from the settings on the phone)
            $phone->updateForRoom($resident['Rooms']);
            $phone->save();

            // Reset phone and thereby delete the users information.
            if($phone->get('technology') == 'SIP') {
                try {
                    $phone->uploadConfiguration(true);
                    $phone->pruneAsteriskPeer();
                    $resetSuccessful[$resident->get('id')] = true;
                } catch (Exception $e) {
                    $resetSuccessful[$resident->get('id')] = false;
                }
            }
        }
    }


    /* Notify the team */
    if($options['notify-team'] && count($residentsMovingOutYesterday) > 0) {
        $messageBody = get_partial('global/todaysLockedResidents', array('residentsMovingOut' => $residentsMovingOutYesterday));

        $message = Swift_Message::newInstance()
            ->setFrom(sfConfig::get('hekphoneFromEmailAdress'))
            ->setTo(sfConfig::get('hekphoneFromEmailAdress'))
            ->setSubject('nach Auszug gesperrt')
            ->setBody($messageBody);
        sfContext::getInstance()->getMailer()->send($message);
    }


    /* Print a list of all users moving out today or tomorrow if no commandline options are set*/
    if( ! $options['lock'] && ! $options['warn-resident'] && ! $options['notify-team'] && ! $options['silent'] && ! $options['reset-phone']) {
        if(count($residentsMovingOutYesterday) > 0) {
            $this->log($this->formatter->format("Residents who moved out yesterday:", 'INFO'));
            print_r($residentsMovingOutYesterday->toArray());
        } else {
            $this->log($this->formatter->format("No residents moved out yesterday.", 'INFO'));
        }

        if(count($residentsMovingOutToday) > 0) {
            $this->log($this->formatter->format("Residents moving out today:", 'INFO'));
            print_r($residentsMovingOutToday->toArray());
        } else {
            $this->log($this->formatter->format("There are no residents moving out today.", 'INFO'));
        }

        if(count($residentsMovingOutTomorrow) > 0) {
            $this->log($this->formatter->format("Residents moving out tomorrow:", 'INFO'));
            print_r($residentsMovingOutTomorrow->toArray());
        } else {
            $this->log($this->formatter->format("There are no residents moving out tomorrow.", 'INFO'));
        }
    }

  }
}