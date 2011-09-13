<?php
// get database and fixtures ready
include(dirname(__FILE__).'/../bootstrap/Doctrine.php');

$t = new lime_test(2);

$t->comment('AsteriskCdrTable->findUnallocatedCalls()');
$t->comment('check if there is the right number of residents selected');
$cdrTable = Doctrine_Core::getTable('AsteriskCdr');
$calls = $cdrTable->findUnallocatedCalls(array('from' => '2010-01-01', 'to' => '2011-12-12'));
$t->is(count($calls), 3);

print_r($calls->toArray());

$t->comment('try to bill these calls');
foreach($calls as $call) {
  $call->bill();
}
$t->pass('no exceptions so everything went fine');