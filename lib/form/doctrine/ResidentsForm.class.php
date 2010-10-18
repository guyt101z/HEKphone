<?php

/**
 * Residents form.
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ResidentsForm extends BaseResidentsForm
{
  public function configure()
  {
    // Don't display widgets for these forms because the get overwritten by the
    // hekphone:sync-residents-data task.
    unset($this['move_in']);
    unset($this['move_out']);
    unset($this['room']);
    unset($this['last_name']);
    unset($this['first_name']);

    // We use identifiers for i18n
    $this->getWidget('email')->setLabel('resident.email');
    $this->getWidget('bill_limit')->setLabel('resident.bill_limit');
    $this->getWidget('warning1')->setLabel('resident.warning1');
    $this->getWidget('warning2')->setLabel('resident.warning2');
    $this->getWidget('unlocked')->setLabel('resident.unlocked');
    $this->getWidget('shortened_itemized_bill')->setLabel('resident.shortenied_itemized_bill');
    $this->getWidget('hekphone')->setLabel('resident.hekphone');
    $this->getWidget('account_number')->setLabel('resident.account_number');


    // Don't provide a choice of all available banks, because there are just too much (<-performance)
    // Provide a simple text input widget. WouldBeNice: asynchronous lookup of the bank
    unset($this['bank_number']);
    $this->setWidget('bank_number', new sfWidgetFormInputText(array('label' => 'resident.bank_number')));
    $this->setValidator('bank_number', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Banks'), 'required' => false)));

    // Manage comments (add/remove) provided by sfDoctrineDynamicFormRelationsPlugin
    $this->embedDynamicRelation('Comments');

    // The password is md5 encrypted (managed in the ResidentModel by defining a setPassword() function)
    // we don't want to display the md5-hash in the form, because we don't want to change the password at
    // all if the value is empty. So we need to set the default-value to ''.
    // Because a DoctrineObject is associated with the form as we instance it, and this overrides any
    // changes to the default value we define here; We have to do this in the action.
    // The label should be "change password to" (or similar)
    unset($this['password']);
    $this->setWidget('password', new sfWidgetFormInputText(array('label' => 'resident.edit.change_password')));
    $this->setValidator('password', new sfValidatorString(array('max_length' => 255, 'required' => false)));


  }
}