<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctional(new sfBrowser());

$browser->info("1.1 - Exists?")->
  get('/auth/index')->
  with('request')->begin()->
    isParameter('module', 'auth')->
    isParameter('action', 'index')->
  end()->

  info("1.1 - Are there untranslated Strings?")->
  with('response')->begin()->
    checkElement('body', '!/[T]/')->
  end()
;

# Test a simple login
$browser->info("2.1 - logging in with incorrect password but valid input");
$browser->
  get('auth/index')->

  click('Absenden', array(
    'login' => array(
      'roomNo' => '405',
      'password' => 'asdasd')))->

  with('request')->begin()->
    isParameter('module', 'auth')->
    isParameter('action', 'index')->
  end()->

  with('user')->begin()->
    isAuthenticated(false)->
  end()->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  # got redirected to the login-form?
  with('response')->isRedirected()->
    followRedirect()->
  with('request')->begin()->
    isParameter('module','auth')->
    isParameter('action','index')->
  end();

# Test a simple login
$browser->info("2.2 - logging in with incorrect password and invalid input");
$browser->
  get('auth/index')->

  click('Absenden', array(
    'login' => array(
      'roomNo' => '40asd5',
      'password' => 'asdasd')))->

  with('form')->begin()->
    hasErrors(true)->
  end()->

  with('user')->begin()->
    isAuthenticated(false)->
  end();

$browser->info("2.3 - logging in with correct password and valid input");
$browser->
  get('auth/index')->

  click('Absenden', array(
    'login' => array(
      'roomNo' => '405',
      'password' => 'propel')))->

  with('form')->begin()->
    hasErrors(false)->
  end()->

  # redirected to the calls table?
  with('response')->isRedirected()->
    followRedirect()->
  with('request')->begin()->
    isParameter('module','calls')->
    isParameter('action','index')->
  end()->

  # all should end in the user being authenticated
  with('user')->begin()->
    isAuthenticated(true)->
  end();