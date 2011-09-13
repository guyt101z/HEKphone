<?php
// get database and fixtures ready
include(dirname(__FILE__).'/../bootstrap/Doctrine.php');

$t = new lime_test(11);

$t->comment('This test checks wheter the charging methods work as expected');

$t->comment('get rate for 49711... at provider "Telekom" should be 1');
$ratesTable = Doctrine_Core::getTable('Rates');
$rate = $ratesTable->findByNumberAndProvider("4971120393920", "Telekom");
$t->is($rate['id'], 1);

$t->comment('get charge for a 2 minute calls to 49711.... at noon should be 4ct');
$charge = $rate->getCharge(120, '2010-10-01 12:00:00');
$t->is($charge, 4);

$t->comment('get charge for a 2 minute calls to 49711.... past 6am should be 2ct');
$charge = $rate->getCharge(120, '2010-10-01 23:00:00');
$t->is($charge, 2);

$t->comment('get rate for 49721... at provider "Vodafone" should be 3 (not 1 as before!)');
$ratesTable = Doctrine_Core::getTable('Rates');
$rate = $ratesTable->findByNumberAndProvider("49711203920002", "Vodafone");
$t->is($rate['id'], 3);

$t->comment('rate 3 has no secondary rate assigned charge should be calculated using primary rate');
$charge = $rate->getCharge(120, '2010-10-01 23:00:00');
$t->is($charge, 240);
$t->comment('everytime');
$charge = $rate->getCharge(120);
$t->is($charge, 240);

$uniqueidNonfree = '1266688418.2221';
$t->comment('try to bill call with uniqueid ' . $uniqueidNonfree . '. should be a call...');
$t->comment('... to 49711 and provider "Telekom" so rate 1');
$t->comment('... in primary period so primary_time_rate = 2ct/min');
$t->comment('... from room 405');
$t->comment('... initially not billed');
$t->comment('Charge should be 4ct.');
$cdrsTable = Doctrine_Core::getTable('AsteriskCdr');
$cdr = $cdrsTable->findOneBy('uniqueid', $uniqueidNonfree);
$charges = $cdr->bill($logger);
$t->is($charges, 4);

$uniqueidNonfree = '1266688418.2222';
$t->comment('try to bill call with uniqueid ' . $uniqueidNonfree . '. should be a call...');
$t->comment('... to 49711 and provider "Telekom" so rate 1');
$t->comment('... in secondary period so secondary_time_rate = 1ct/min');
$t->comment('... from room 405');
$t->comment('... initially not billed');
$t->comment('Charge should be 2ct.');
$cdrsTable = Doctrine_Core::getTable('AsteriskCdr');
$cdr = $cdrsTable->findOneBy('uniqueid', $uniqueidNonfree);
$charges = $cdr->bill($logger);
$t->is($charges, 2);

$t->comment('try to bill it again. should fail because it\'s already billed');
try
{
  $cdr->bill($logger);
  $t->fail('no code should be executed after throwing an exception');
}
catch (Exception $e)
{
  $t->pass($e->getMessage());
}

$t->comment('try to bill it again with rebille=true. should work. charges should be again 2ct');
$charges = $cdr->rebill($logger);
$t->is($charges, 2);

//$t->comment('deleting the created calls entry should also delete the asterisk_cdr');
//$cdr->free();
//Doctrine_Query::create()->delete('Calls c')->where('c.asterisk_uniqueid = ?', $uniqueidNonfree)->execute();
//$deleteFetchResult = Doctrine_Query::create()->select()->from('AsteriskCdr')->where('uniqueid = ?', $uniqueidNonfree)->execute();
//print_r($deleteFetchResult->count());
//$t->is($deleteFetchResult->count(), 0);

$t->comment('Allocate a free call');
$t->comment('... denoted by userfield = free');
$t->comment('... charges should be 0ct');
$cdrsTable = Doctrine_Core::getTable('AsteriskCdr');
$cdr = $cdrsTable->findOneBy('uniqueid', '1266695033.1368');
$charges = $cdr->bill($logger);
$t->is($charges, 0);