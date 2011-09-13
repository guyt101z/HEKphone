<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctional(new sfBrowser());
$browser->setHttpHeader('ACCEPT_LANGUAGE', 'de_DE,de,en;q=0.7');

$browser->info("1.1 - Exists?")->
  get('/login')->
  with('request')->begin()->
    isParameter('module', 'auth')->
    isParameter('action', 'index')->
  end()->

  info("1.1 - Are there untranslated Strings?")->
  with('response')->begin()->
    checkElement('body', '!/\[T\]/')->
  end();

# Test a simple login
$browser->info("2.1 - logging in with incorrect password but valid input")->
  get('/login')->

  click('Absenden', array(
    'login' => array(
      'roomNo' => '405',
      'password' => 'asddqwce324')))->

  with('request')->begin()->
    isParameter('module', 'auth')->
    isParameter('action', 'index')->
  end()->

  with('user')->begin()->
    isAuthenticated(false)->
  end()->

  with('form')->begin()->
    hasErrors(false)->
  end();

$browser->info("2.1.1 - Are there untranslated Strings?")->
  with('response')->begin()->
    checkElement('body', '!/[T]/')->
  end();

# Test a simple login
$browser->info("2.2 - logging in with incorrect password and invalid input")->
  get('login')->

  click('Absenden', array(
    'login' => array(
      'roomNo' => '40asd5',
      'password' => 'asdas234add')))->

  with('form')->begin()->
    hasErrors(true)->
  end()->

  with('user')->begin()->
    isAuthenticated(false)->
  end()->

  info("2.2.1 - Are there untranslated Strings?");
  echo "TEST BROKEN HERE." . PHP_EOL;
  //with('response')->begin()->
    //checkElement('body', '!/[T]/')->
  //end();

$browser->info("2.3 - logging in with correct password and valid input and as hekphone member")->
  get('/login')->

  click('Absenden', array(
    'login' => array(
      'roomNo'   => '405',
      'password' => 'hekphone')))->

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
  # and in our case: have hekphone credentials
  with('user')->begin()->
    isAuthenticated(true)->
    hasCredential('hekphone')->
  end();

$browser->info("2.3 - logging in with correct password and valid input")->
  get('/logout')->
  get('/login')->

  click('Absenden', array(
    'login' => array(
      'roomNo'   => '403',
      'password' => 'dude')))->

  with('user')->begin()->
    isAuthenticated(true)->
    hasCredential('hekphone', false)->
  end();