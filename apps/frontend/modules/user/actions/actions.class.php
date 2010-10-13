<?php

/**
 * user actions.
 *
 * @package    hekphone
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new LoginForm();
  }

  public function executeLogin(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    ## not neccessary as long as we dont't validate the form or else
    #$this->form = new LoginForm();
    #$this->form->bind($request->getParameter('login'));

    $residentsTable = Doctrine_Core::getTable('Residents');
    $resident = $residentsTable->findByRoomNo($request['login']['roomNo']);

    if(null !== $resident && $resident->password === md5($request['login']['password']))
    {
      $this->getUser()->setAuthenticated(true);
      $this->getUser()->setAttribute("name", $resident->first_name);
      $this->getUser()->setFlash('notice', "Logged in successfully");
    }
    else
    {
      $this->getUser()->setFlash('notice', 'Login failed! Check room number and password.');
      $this->redirect('user/index');
    }
  }

}
