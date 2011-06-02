<?php

class hekphoneCreatebillsTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('start', null, sfCommandOption::PARAMETER_OPTIONAL, 'Start date of bills'),
      new sfCommandOption('end', null, sfCommandOption::PARAMETER_OPTIONAL, 'End date of bills (bills include this day)'),
      new sfCommandOption('simulate', null, sfCommandOption::PARAMETER_NONE, 'Simulate bill creation. Don\'t send emails, don\'t mark calls as paied')
    ));

    // Prepare rendering of partials (load the PartialHelper)
    $configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
    sfContext::createInstance($configuration);
    sfProjectConfiguration::getActive()->loadHelpers("Partial");

    $this->namespace        = 'hekphone';
    $this->name             = 'create-bills';
    $this->briefDescription = 'Creates bills for residents for a given time period [default:last month]';
    $this->detailedDescription = <<<EOF
The [hekphone:create-bills|INFO] creates for all unbilled calls in a given time period a bill for the dedicated user.
Furthermore it creates an itemized Bill and sends it via mail to the resident.
Call it with:

  [php symfony hekphone:create-bills|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // choose the last month as bill date if the user doesn't specify
    // a time period via $options['fromDate'] and $options['toDate']
    // if he only provided one of the parameters quit.
    if($options['start'] == null && $options['end'] == null)
    {
        $start  = date("Y-m-01", strtotime("-1 month", strtotime(date("Y-m-d"))));
        $end    = date("Y-m-d", strtotime("-1 day", strtotime(date("Y-m-01"))));
    }
    elseif($options['start'] == null)
    {
       throw new sfCommandException('start parameter is missing. Provide both parameters or none.');
    }
    elseif($options['end'] == null)
    {
       throw new sfCommandException('end parameter is missing. Provide both parameters or none');
    }
    else
    {
       $start = $options['start'];
       $end   = $options['end'];
    }

    if($billsCollection = Doctrine_Core::getTable('Bills')->getBillsCollectionForUnbilledCalls($start, $end))
    {
        $billsCollection->save();  //save the bills to the database and obtain billids
        $billsCollection->linkCallsToBills(); //relate the calls to the bills (mark them as billed)
        $billsCollection->loadRelated();
        print_r($billsCollection->toArray());
        $billsCollection->sendEmails();
        $this->log($this->formatter->format("Bills succesfully created", 'INFO'));
    }
    else
    {
        $this->log($this->formatter->format("No bills to create in the given time period", 'INFO'));
    }





  }
}
