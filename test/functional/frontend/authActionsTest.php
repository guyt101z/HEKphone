<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctional(new sfBrowser());

$browser->
  get('/auth/index')->

  with('request')->begin()->
    isParameter('module', 'auth')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()
;

//# Test a simple login
//$browser
//  ->get('auth/login')
//  ->with('request')->begin()
//    ->isParameter('module', 'auth')
//    ->isParameter('action', 'login')
//  ->end
//
//  ->click('Submit', array(
//    'login' => array(
//      'roomNo' => '405',
//      'password' => 'xyz')))
//
//  ->with('request')->begin()
//    ->isParameter('module', 'auth')
//    ->isParameter('action', 'index')
//  ->end
//
//  ->with('response')->begin()
//    ->isStatusCode(200)
//  ->end;
