<?php
class ContinueBillsForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'date'     => new sfWidgetFormI18nDate(array('default' => date('Y-m-d', mktime(0,0,0, date('m'), 1, date('Y'))),
                                                              'culture' => 'de', //FIXME: choose the Users culutre here!
                                                              'format' => '%year% - %month% - %day%')),
      'include_already_debited'     => new sfWidgetFormInputCheckbox(),
    ));

    $this->widgetSchema->setNameFormat('continueBills[%s]');

    $this->widgetSchema->setLabels(array(
      'date'     => 'task.bills.continue.choose_date',
      'include_already_debited'     => 'task.bills.continue.include_already_debited',
    ));

    $this->setValidators(array(
      'date'     => new sfValidatorDate(),
      'include_already_debited'     => new sfValidatorBoolean(array('required' => false)),
    ));

    $decorator = new sfWidgetFormSchemaFormatterDiv($this->getWidgetSchema());
    $this->getWidgetSchema()->addFormFormatter('div', $decorator);
    $this->getWidgetSchema()->setFormFormatterName('div');
  }
}
