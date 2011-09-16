<?php
// get database and fixtures ready
include(dirname(__FILE__).'/../bootstrap/Doctrine.php');

$t = new lime_test(3);

$numberUnallocatedCalls = 3;
$t->comment('AsteriskCdrTable->findUnallocatedCalls()');
$t->comment('1) Check if there is the right number of cdrs (' . $numberUnallocatedCalls . ') selected.');
$cdrTable = Doctrine_Core::getTable('AsteriskCdr');
$calls = $cdrTable->findUnallocatedCalls(array('from' => '2010-01-01', 'to' => '2011-12-12'));
$t->is(count($calls), $numberUnallocatedCalls);

$t->comment('2) Try to bill these '. $numberUnallocatedCalls .' calls.');
$count = 0;
foreach($calls as $call) {
  $call->bill();
  ++$count;
}
$t->is($count, $numberUnallocatedCalls);

$t->comment('3) There should be no unallocated calls left now.');
$calls = $cdrTable->findUnallocatedCalls(array('from' => '2010-01-01', 'to' => '2011-12-12'));
$t->is(count($calls), 0);