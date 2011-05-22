<?php
// get database and fixtures ready
include(dirname(__FILE__).'/../bootstrap/unit.php');
//require_once(dirname(__FILE__).'/../../lib/model/Voicemessage.class.php');
//require_once(dirname(__FILE__).'/../../lib/model/VoicemessageFolder.class.php');

$t = new lime_test(1);

$t->comment('You need to set sfConfig:asteriskVoicemailDir to a directory where the filestructure as created by asterisk exists.');
$t->comment('Instantiate a representation of the VM-Box of user 943');
$vmbox = VoicemessageFolder::getVoicemailbox(943);
$t->ok($vmbox instanceof VoicemessageFolder);
print_r($vmbox->toArray());

#if($message = $vmbox->getOldMessage(1)) {
#  print_r($message->toArray());
#  $message->markAsNew();
#}
#$vmbox->loadMessages();
#print_r($vmbox->toArray());

if($message = $vmbox->getNewMessage(0)) {
  print_r($message->toArray());
  $message->markAsOld();
} else {
  $t->comment('no new message "2" available');
}
$vmbox->loadMessages();
print_r($vmbox->toArray());