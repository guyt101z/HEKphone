<?php

class hekphoneBillcallTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('rebill', null, sfCommandOption::PARAMETER_NONE, 'Bill a given call even if it has been marked as billed already'),

      new sfCommandOption('uniqueid', null, sfCommandOption::PARAMETER_REQUIRED, 'Uniqueid of the call to be billed. if this is the only parameter, fetches the call from the database.'),
      new sfCommandOption('dst', null, sfCommandOption::PARAMETER_REQUIRED, ''),
      new sfCommandOption('dcontext', null, sfCommandOption::PARAMETER_REQUIRED, ''),
      new sfCommandOption('src', null, sfCommandOption::PARAMETER_REQUIRED, ''),
      new sfCommandOption('billsec', null, sfCommandOption::PARAMETER_REQUIRED, ''),
      new sfCommandOption('calldate', null, sfCommandOption::PARAMETER_REQUIRED, ''),
      new sfCommandOption('userfield', null, sfCommandOption::PARAMETER_REQUIRED, ''),
      new sfCommandOption('disposition', null, sfCommandOption::PARAMETER_REQUIRED, ''),
      new sfCommandOption('channel', null, sfCommandOption::PARAMETER_REQUIRED, ''),

      new sfCommandOption('silent', null, sfCommandOption::PARAMETER_NONE, 'Suppress logging to stdout. '),
    ));

    $this->namespace        = 'hekphone';
    $this->name             = 'bill-call';
    $this->briefDescription = 'Biphalls an entry in AsteriskCdr with given uniqueid';
    $this->detailedDescription = <<<EOF
The [hekphone:bill-call|INFO] task takes a uniqueid from asterisk_cdr or every detail of a call as argument.
It then tries to match the source to a room, the room to an resident/user and the dialed number to an rate.
It's supposed to be called with the calls details everytime an outgoing call has ended.

Call it with:

  [php symfony hekphone:bill-call --uniqueid="asterisk.2398472394782"|INFO] fetches call details from database
  [php symfony hekphone:bill-call --uniqueid="asterisk.2398472394782" --dst="002323" --src=... ...|INFO] provide every neccesarry detail using the paramete
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $logger = new sfAggregateLogger($this->dispatcher);
    $logger->addLogger(new sfFileLogger($this->dispatcher, array('file' => $this->configuration->getRootDir() . '/log/bill-call.log')));
    if( ! $options['silent']) {
        $logger->addLogger(new sfCommandLogger($this->dispatcher));
    }

    if(isset($options['uniqueid'])
        && ! isset($options['dst'])
        && ! isset($options['dcontext'])
        && ! isset($options['src'])
        && ! isset($options['billsec'])
        && ! isset($options['calldate'])
        && ! isset($options['disposition'])
        && ! isset($options['userfield'])
        && ! isset($options['channel'])) {
        /* ifmore than only a uniqueid is specified, get the calls details from the commandline
         * parameters and create a cdr-object from them. fail if a parameter is missing */
        $cdr  = Doctrine_Query::create()
                ->from('AsteriskCdr')
                ->where('uniqueid = ?', $options['uniqueid'])
                ->fetchOne();
        if ( ! $cdr) {
            $logger->err("[uniqueid='" . $options['uniqueid'] . "'] Could not bill call. Cdr not present in asterisk_cdr.");
            die;
        }
    } elseif(isset($options['uniqueid'])
             && isset($options['dst'])
             && isset($options['dcontext'])
             && isset($options['src'])
             && isset($options['billsec'])
             && isset($options['calldate'])
             && isset($options['disposition'])
             && isset($options['userfield'])
             && isset($options['channel'])) {
        /* if no uniqueid is specified, get the calls details from the commandline
         * parameters and create a cdr-object from them. fail if a parameter is missing */
        $cdrArray = array();
        $cdrArray['uniqueid']    = $options['uniqueid'];
        $cdrArray['dst']         = $options['dst'];
        $cdrArray['dcontext']    = $options['dcontext'];
        $cdrArray['src']         = $options['src'];
        $cdrArray['billsec']     = $options['billsec'];
        $cdrArray['calldate']    = $options['calldate'];
        $cdrArray['disposition'] = $options['disposition'];
        $cdrArray['userfield']   = $options['userfield'];
        $cdrArray['channel']     = $options['channel'];

        $cdr = new AsteriskCdr();
        $cdr->fromArray($cdrArray);
    } else {
        throw new sfCommandException("Provide just a uniqueid or all parameters of the call");
    }

    /* bill the call and catch every possible error, format it and rethrow it */
    try
    {
      if($options['rebill'] == true) {
          $cdr->rebill($logger);
      } else {
          $cdr->bill($logger);
      }
    }
    catch (Exception $e)
    {
      $logger->err("[uniqueid='{$cdr->uniqueid}'] " . $e->getMessage());
      throw new sfCommandException("[uniqueid='{$cdr->uniqueid}'] " . $e->getMessage());
    }

  }
}
