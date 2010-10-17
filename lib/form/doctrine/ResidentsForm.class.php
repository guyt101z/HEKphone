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
    unset($this['bank_number']);
    unset($this['move_in']);
    unset($this['move_out']);

    $this->setWidget('bank_number', new sfWidgetFormInputText());
    $this->setValidator('bank_number', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Banks'), 'required' => false)));
  }
}
