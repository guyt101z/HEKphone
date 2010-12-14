<?php
// get database and fixtures ready
include(dirname(__FILE__).'/../bootstrap/Doctrine.php');

$t = new lime_test(1);

$t->comment('AsteriskCdrTable->findUnallocatedCalls()');
$cdrTable = Doctrine_Core::getTable('AsteriskCdr');
$cdrTable->findUnallocatedCalls('01.01.2010', '01.01.2010');
$t->is(5, $cdrTable->count());