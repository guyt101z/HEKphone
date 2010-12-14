<?php
// get database and fixtures ready
include(dirname(__FILE__).'/../bootstrap/Doctrine.php');


$t = new lime_test(10);

$t->comment('This test checks wheter the charging methods work as expected');

$t->comment('get rate for 49711... at provider "Telekom" should be 1');
$ratesTable = Doctrine_Core::getTable('Rates');
$rate = $ratesTable->findByNumberAndProvider("49711203920002", "Telekom");
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



$t->comment('try to bill call with uniqueid 1266681862.1216. should be a call...');
$t->comment('... to 49711 and provider "Telekom" so rate 1');
$t->comment('... from room 405');
$t->comment('... initially not billed');
$t->comment('Charge should be 2ct! CHECK MANUALLY');
$cdrsTable = Doctrine_Core::getTable('AsteriskCdr');
$cdr = $cdrsTable->findOneBy('uniqueid', '1266681862.1216');
$cdr->bill();
$t->pass('rebilled the cdr successfully');

$t->comment('try to bill it again. should fail because it\'s already billed');
try
{
  $cdr->bill();
  $t->fail('no code should be executed after throwing an exception');
}
catch (Exception $e)
{
  $t->pass($e->getMessage());
}


$t->comment('try to bill it again with rebille=true. should work');
$cdr->bill(true);
$t->pass('rebilled the cdr successfully');

$t->comment('Allocate a free call');
$t->comment('... denoted by userfield = free');
$cdrsTable = Doctrine_Core::getTable('AsteriskCdr');
$cdr = $cdrsTable->findOneBy('uniqueid', '1266686881.1279');
$cdr->bill();
$t->pass('"billed" free call successfully');