<?php

/**
 * Phones form.
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PhonesForm extends BasePhonesForm
{
  public function configure()
  {
    unset($this['regserver']);
    unset($this['regseconds']);
    unset($this['fullcontact']);
    unset($this['useragent']);
    unset($this['lastms']);
    unset($this['fromuser']);
    unset($this['fromdomain']);

    // unset($this['ipaddr']); there may be hosts with static ip
    // unset($this['port']);   and port so we display these fields
    $this->widgetSchema->setHelp('ipaddr', 'phone.help.ipaddr');
    $this->widgetSchema->setHelp('port', 'phone.help.port');

    $this->widgetSchema->setHelp('mailbox', 'phone.help.mailbox');

  }
}
