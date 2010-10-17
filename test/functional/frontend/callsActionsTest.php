<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctional(new sfBrowser());

$browser->
  info('0.1 Log in first.')->
  get('auth/index')->
  click('Absenden', array(
    'login' => array(
      'roomNo' => '405',
      'password' => 'propel')))->

  info('1.1 are we on the right page?')->
  get('/calls/index')->
  with('response')->begin()->
    isRedirected(false)->
  end()->

  info('1.2 Any untranslated strings?')->
  with('response')->begin()->
    checkElement('body', '!/[T]/')->
  end()
;
