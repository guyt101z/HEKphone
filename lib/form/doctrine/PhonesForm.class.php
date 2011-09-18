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
    $this->setWidget('room', new sfWidgetFormDoctrineChoice(array(
      'model'     => 'Rooms',
      'add_empty' => true,
      'order_by'  => array('room_no', 'asc'),
      ), array('disabled' => 'true')
      ));
    $this->setValidator('room', new sfValidatorDoctrineChoice(array('model' => 'Rooms')));

    unset($this['mac']);
    $this->setWidget('mac', new sfWidgetFormInputText(array(), array('placeholder' => 'ab:cd:ef:12:34:45:67')));
    $this->setValidator('mac', new sfValidatorPass());
    $this->mergePostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'checkMac'))));     // Check mac-adress only if technology is set to 'SIP'

    unset($this['host']);       // always dynamic. the phones can't handle static
    unset($this['type']);       // always frient. may place and receive calls.

    unset($this['name']);       // V fetch the following when updating by the room and the person living there
    unset($this['callerid']);   // | equals Name <1+Roomnumber>
    unset($this['defaultuser']);// | equals 1+roomnumber
    unset($this['defaultip']);  // | equals 192.168.floornumber.roomNumberOnFloor
    unset($this['mailbox']);    // | equals residents id@default
    unset($this['language']);   // | equals residents culture setting

    unset($this['ipaddr']);     // V gets updated by asterisk
    unset($this['port']);       // |
    unset($this['regserver']);  // |
    unset($this['regseconds']); // |
    unset($this['fullcontact']);// |
    unset($this['useragent']);  // |
    unset($this['lastms']);     // |
    unset($this['fromuser']);   // |
    unset($this['fromdomain']); // |

    $decorator = new sfWidgetFormSchemaFormatterDiv($this->getWidgetSchema());
    $this->getWidgetSchema()->addFormFormatter('div', $decorator);
    $this->getWidgetSchema()->setFormFormatterName('div');
  }


  /**
   * Checks wheter a mac adress is specified and if it matches the notation with
   * xx:xx:xx:xx:xx:xx only if technology is set to SIP
   *
   * @param $validator
   * @param $values
   * @throws sfValidatorErrorSchema
   */
  public function checkMac($validator, $values) {
      if($values['technology'] == 'SIP') {
        if( ! $values['mac']) {
            $error = new sfValidatorError($validator, 'phone.edit.mac.required');
            throw new sfValidatorErrorSchema($validator, array('mac' => $error));
        }
        if( ! preg_match('/^[a-f0-9]{2}:[a-f0-9]{2}:[a-f0-9]{2}:[a-f0-9]{2}:[a-f0-9]{2}:[a-f0-9]{2}$/i', $values['mac'])) {
            $error = new sfValidatorError($validator, 'phone.edit.mac.invalid');
            throw new sfValidatorErrorSchema($validator, array('mac' => $error));
        }
      }

      return $values;
  }
}