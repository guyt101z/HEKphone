<?php

/**
 * tasks actions.
 *
 * @package    hekphone
 * @subpackage tasks
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tasksActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward404();
  }

  public function executeBillCall(sfWebRequest $request) {
    chdir(sfConfig::get('sf_root_dir'));
    $formatter = new sfFormatter();
    $task = new hekphoneBillcallTask($this->dispatcher, $formatter);
    try {
      $task->run($request->getParameter('uniqueid'));
    } catch (Exception $e) {
      //catch exceptions and "rethrow them as flash to display in the indexTemplate".
      $this->getUser()->setFlash('error', 'The task did not complete: ' . $e->getMessage() . '.');
    }
    $this->redirect('tasks/index');
  }

}
