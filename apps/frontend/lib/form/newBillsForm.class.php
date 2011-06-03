<?php
class NewBillsForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'billingperiod_start'     => new sfWidgetFormI18nDate(array('default' => date('Y-m-d', mktime(0,0,0, date('m')-2, 1, date('Y'))),
                                                              'culture' => 'de', //FIXME: choose the Users culutre here!
                                                              'format' => '%year% - %month% - %day%')),
      'billingperiod_end'       => new sfWidgetFormI18nDate(array('default' => date('Y-m-d', mktime(0,0,0, date('m'), 0, date('Y'))),
                                                              'culture' => 'de', //FIXME: choose the Users culutre here!
                                                              'format' => '%year% - %month% - %day%')),
    ));

    $this->widgetSchema->setNameFormat('newBills[%s]');

    $this->widgetSchema->setLabels(array(
      'billingperiod_start'     => 'task.bills.create.date_start',
      'billingperiod_end'   => 'task.bills.create.date_end'
    ));

    $this->setValidators(array(
      'billingperiod_start'     => new sfValidatorDate(),
      'billingperiod_end'       => new sfValidatorDate()
    ));

    $decorator = new sfWidgetFormSchemaFormatterDiv($this->getWidgetSchema());
    $this->getWidgetSchema()->addFormFormatter('div', $decorator);
    $this->getWidgetSchema()->setFormFormatterName('div');
  }
}
