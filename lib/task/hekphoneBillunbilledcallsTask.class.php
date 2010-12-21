<?php

class hekphoneBillunbilledcallsTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('count', null, sfCommandOption::PARAMETER_REQUIRED, 'Number of last calls to bill.', '20'),
    ));

    $this->namespace        = 'hekphone';
    $this->name             = 'bill-unbilled-calls';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [hekphone:bill-all-unbilled-calls|INFO] fetches the last \$count unbilled calls from AsteriskCdr
assigns a charge and a rate to them and transfers them to the Calls table.
Call it with:

  [php symfony hekphone:bill-unbilled-calls|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $collCdr  = Doctrine_Query::create()
              ->from('AsteriskCdr')
              ->where('billed = ?', false)
              ->addWhere('dcontext = ? ', 'anlage')
              ->addWhere('disposition = ?', 'ANSWERED')
              ->limit($options['count'])
              ->execute();

    foreach($collCdr as $cdr)
    {
        try {
            $cdr->bill();
        } catch (Exception $e) {
            $this->log($this->formatter->format("[uniqueid='{$cdr->uniqueid}']" . $e->getMessage(), 'ERROR'));
        }
    }
  }
}
