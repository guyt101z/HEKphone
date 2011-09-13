<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctional(new sfBrowser());
$browser->setHttpHeader('ACCEPT_LANGUAGE', 'de_DE,de,en;q=0.7');

$browser->
  info('0.1 Log in...')->
  get('/login')->
  click('Absenden', array(
    'login' => array(
      'roomNo' => '405',
      'password' => 'hekphone')));

$browser->info('1.1 are we on the right page?')->
  get('/calls')->
  with('response')->begin()->
    isRedirected(false)->
  end();

$browser->info('1.1 Checking for any untranslated strings in the following tests');

$browser->info('1.2 is there a bill listed and has a clickable "show details" button and no hide buttons?')->
  get('/calls')->with('response')->begin()->
    checkElement('body', '/zeigen/')->
    checkElement('td', '!/ausblenden/')->
    checkElement('body', '!/\[T\]/')->
  end();

$browser->info('1.3 are the details of a bill shown?')->
  get('/calls')->
  click('zeigen')->with('response')->begin()->
    checkElement('body', '/ausblenden/')->
    checkElement('body', '!/\[T\]/')->
  end();

$browser->info('1.3 the details of a bill of an other user should not be shown')->
  get('/calls', array('billid' => '3'))->with('response')->begin()->
    checkElement('body', '!/ausblenden/')->
    checkElement('body', '!/\[T\]/')->
  end();

$browser->info('2 checking /resident/xxx/urls');
$browser->info('2.1 A user trying to access his own call details via /resident/:hisuserid/calls')->
  get('logout')->
  get('login')->
  click('Absenden', array(
    'login' => array(
      'roomNo'   => '403',
      'password' => 'dude')))->
  with('user')->begin()->
    hasCredential('hekphone', false)->
  end()->

  get('/resident/3/index')->
  with('response')->begin()->
    isRedirected(false)->
  end();

$browser->info('2.2 A non hekphone member trying to access the call details of another user via /resident/:hisuserid/calls fails')->
  get('/calls', array('residentid' => '1'))->
  with('user')->begin()->
    hasCredential('hekphone', false)->
  end()->
  with('response')->begin()->
    isForwardedTo('default', 'secure')->
  end();

$browser->info('2.3 A hekphone-member trying to access the call details of another user via /resident/:hisuserid/calls')->
  get('/logout')->
  get('/login')->
  click('Absenden', array(
    'login' => array(
      'roomNo'   => '405',
      'password' => 'hekphone')))->

  get('/resident/1/index')->
  with('user')->begin()->
    hasCredential('hekphone')->
  end()->
  with('response')->begin()->
    isRedirected(false)->
  end();
