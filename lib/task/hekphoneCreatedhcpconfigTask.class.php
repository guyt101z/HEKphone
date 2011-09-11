<?php

class hekphoneCreatedhcpconfigTask extends sfBaseTask
{
  protected function configure()
  {

    $this->addOptions(array(
      new sfCommandOption('verbose', null, sfCommandOption::PARAMETER_NONE, 'Print the generated output'),
      new sfCommandOption('no-restart', null, sfCommandOption::PARAMETER_NONE, 'Dont restart the dhcp-server'),
      new sfCommandOption('filename', null, sfCommandOption::PARAMETER_REQUIRED, 'The configuration filename', '/etc/dhcp3/dhcpd.phones'),
      //new sfCommandOption('filename', null, sfCommandOption::PARAMETER_REQUIRED, 'The configuration filename', sfConfig::get('sf_data_dir') . DIRECTORY_SEPARATOR . 'dhcpd.phones'),
      // including an file outside /etc in dhcpd.conf does not work easily on debian machines

      new sfCommandOption('silent', null, sfCommandOption::PARAMETER_NONE, 'Suppress logging to stdout'),
    ));

    $this->namespace        = 'hekphone';
    $this->name             = 'create-dhcp-config';
    $this->briefDescription = 'Creates the DHCP config file for the phones and restarts the dhcp-server';
    $this->detailedDescription = <<<EOF
The [hekphone:create-dhcp-config|INFO] task generates the neccesary dhcp-config to assign an IP to each phone depending on the mac address and roomNo for each phone from the phones table and safes it as \$options(filename) (the old file will be repaced).
The default config (usually dhcpd.config) has to include this file. Afterwards the deamon will be restarted. You probably want to call the task as root.

Call it with:

  [php symfony hekphone:create-dhcp-config|INFO]
EOF;
  }
  protected function execute($arguments = array(), $options = array())
  {
    $logger = new sfAggregateLogger($this->dispatcher);
    $logger->addLogger(new sfFileLogger($this->dispatcher, array('file' => $this->configuration->getRootDir() . '/log/dhcp-config.log')));
    if( ! $options['silent']) {
        $logger->addLogger(new sfCommandLogger($this->dispatcher));
    }

    $collPhones  = Doctrine_Query::create()
                 ->from('Phones')
                 ->where('technology = ?', 'SIP')
                 ->execute();

    $dhcpConf = '# Phone configuration'.PHP_EOL
              . '# Created via symfony task: hekphone:create-dhcp-config'. PHP_EOL
              . 'subnet 192.168.0.0 netmask 255.255.0.0 {' . PHP_EOL;
    $num = 0;
    foreach ($collPhones as $phone) {
        // don't generate corrupt config
        if ( ! $phone->name or ! $phone->mac or ! $phone->defaultip )
          continue;

        // else add section in the config file
        ++$num;
        $dhcpConf .= '
        host phone'.$phone->name.'{
          hardware ethernet '.$phone->mac.';
          fixed-address '.$phone->defaultip.';
        }' . PHP_EOL;
    }
    $dhcpConf .= '}';

    /* Be verbose */
    if( $options['verbose'] == true)
    {
      echo $dhcpConf;
    }

    // Write configuration file
    if( ! $fileHandle = @fopen($options['filename'], 'w+')) {
      throw new sfCommandException('Could not open file ' . $options['filename'] . ' for writing. Do you have sufficient privileges?');
    } if ( ! fwrite($fileHandle, $dhcpConf)) {
      throw new sfCommandException('Failed to write /etc/dhcp3/dhcp.phones. Does the folder exist?');
    } else {
      $logger->notice("Wrote DHCP-Config for $num phones to " . $options['filename'] . ".", 'INFO');
    }

    fclose($fileHandle);

    // Restart dhcp-server
    if( ! $options['no-restart']) {
        // you need to enable www-data (or whoever runs the script) to restart the dhcp-server via sudoers
        if( ! system('/etc/init.d/dhcp3-server restart')) {
            $logger->error('Restarting DCHP-Server failed.');
            throw new sfCommandException('Restarting DHCP-Server failed.');
        };
    }
  }
}
