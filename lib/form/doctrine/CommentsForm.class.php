<?php

/**
 * Comments form.
 *
 * @package    hekphone
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CommentsForm extends BaseCommentsForm
{
  public function configure()
  {
    unset($this['stamp']);
    unset($this['resident']);
    unset($this['comment']);

    $this->setWidget('comment', new sfWidgetFormTextarea(array('label' => 'resident.comment')));
    $this->setValidator('comment', new sfValidatorString(array('max_length' => 1000)));

    // Because the form has only one field, we'll create a very simple formatter
    // that does not wrap the form into any table list or div tag.
    // The formatter ist located in the application level lib/ directory
    $decorator = new sfWidgetFormSchemaFormatterNone($this->getWidgetSchema());
    $this->getWidgetSchema()->addFormFormatter('none', $decorator);
    $this->getWidgetSchema()->setFormFormatterName('none');

    $this->widgetSchema->setFormFormatterName('none');
  }
}
