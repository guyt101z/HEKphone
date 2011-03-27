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
    ));

    $this->namespace        = 'hekphone';
    $this->name             = 'bill-call';
    $this->briefDescription = 'Biphalls an entry in AsteriskCdr with given uniqueid';
    $this->detailedDescription = <<<EOF
The [hekphone:bill-call|INFO] task takes one uniqueid from asterisk_cdr as argument, tries to match the source to a room and matches the room to an resident/user;
It tries to match the dialed number to an rate and calculates the cost of the call in euro-cents (ct).
Then an entry in the "calls" table is created and the call is marked as billed in the asterisk_cdr table.

It's supposed to be called with the calls details everytime an outgoing call has ended.

Call it with:

  [php symfony hekphone:bill-call --uniqueid="asterisk.2398472394782"|INFO]
  [php symfony hekphone:bill-call --uniqueid="asterisk.2398472394782" --dst="002323" --src=...|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    if(isset($options['uniqueid'])
        && ! isset($options['dst'])
        && ! isset($options['dcontext'])
        && ! isset($options['src'])
        && ! isset($options['billsec'])
        && ! isset($options['calldate'])
        && ! isset($options['disposition'])
        && ! isset($options['userfield'])
        && ! isset($options['channel'])) {
        /* if a uniqueid is specified, get this call defail record from the table */
        $cdr  = Doctrine_Query::create()
                ->from('AsteriskCdr')
                ->where('uniqueid = ?', $options['uniqueid'])
                ->fetchOne();
        if ( ! $cdr) {
            $this->log($this->formatter->format("[uniqueid='" . $options['uniqueid'] . "'] Cdr not present in asterisk_cdr", 'ERROR'));
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
          $cdr->rebill();
      } else {
          $cdr->bill();
      }
    }
    catch (Exception $e)
    {
      throw new sfCommandException("[uniqueid='{$cdr->uniqueid}'] " . $e->getMessage());
    }

  }
}
