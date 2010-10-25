<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctional(new sfBrowser());

$browser->
  info('0.1 Log in...')->
  get('auth/index')->
  click('Absenden', array(
    'login' => array(
      'roomNo' => '405',
      'password' => 'propel')));

$browser->info('1.1 are we on the right page?')->
  get('/calls/index')->
  with('response')->begin()->
    isRedirected(false)->
  end();

$browser->info('1.1 Checking for any untranslated strings in the following tests');

$browser->info('1.2 is there a bill listed and has a clickable "show details" button and no hide buttons?')->
  get('/calls/index')->with('response')->begin()->
    checkElement('body', '/zeigen/')->
    checkElement('td', '!/Ausblenden/')->
    checkElement('body', '!/[T]/')->
  end();

$browser->info('1.3 are the details of a bill shown?')->
  get('/calls/index', array('billid' => '1'))->with('response')->begin()->
    checkElement('body', '/ausblenden/')->
    checkElement('body', '!/[T]/')->
  end();

$browser->info('1.3 the details of a bill of an other user should not be shown')->
  get('/calls/index', array('billid' => '3'))->with('response')->begin()->
    checkElement('body', '!/ausblenden/')->
    checkElement('body', '!/[T]/')->
  end();

$browser->info('2 checking /resident/xxx/urls');
$browser->info('2.1 A user trying to access his own call details via /resident/:hisuserid/calls')->
  get('/resident/943/index')->
  //with('request')->begin()->
  //  isParameter('module', 'calls')->
  //  isParameter('action', 'index')->
  //  isParameter('residentid', '943')->
  //end()->
  with('response')->begin()->
    isRedirected(false)->
  end();

$browser->info('2.2 A hekphone-member trying to access the call details of another user via /resident/:hisuserid/calls')->
  get('/resident/1051/index')->
  //with('request')->begin()->
  //  isParameter('module', 'calls')->
  //  isParameter('action', 'index')->
  //  isParameter('residentid', '943')->
  //end()->
  with('user')->begin()->
    hasCredential('hekphone')->
  end()->
  with('response')->begin()->
    isRedirected(false)->
  end();

$browser->info('2.3 A non hekphone-member trying the same thing runs against default/secure')->
  get('calls/index', array('residentid' => '1051'))->
  with('user')->begin()->
    hasCredential('hekphone', false)->
  end()->
  with('response')->begin()->
    isForwardedTo('default', 'secure')->
  end();