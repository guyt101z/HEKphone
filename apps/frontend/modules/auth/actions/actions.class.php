<?php

/**
 * user actions.
 *
 * @package    hekphone
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class authActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new LoginForm();

    if( ! $request->isMethod('post')){
      $this->getUser()->setCulture($request->getPreferredCulture(array('de','en')));
    }
    elseif($request->isMethod('post'))
    {

      $this->form->bind($request->getParameter('login'));
      if ($this->form->isValid())
      {
        $residentsTable = Doctrine_Core::getTable('Residents');
        $resident = $residentsTable->findByRoomNo($request['login']['roomNo']);
        if(null !== $resident && $resident->password === md5($request['login']['password']))
        {
          $this->getUser()->setAuthenticated(true);
          $this->getUser()->addCredential('hekphone');
          $this->getUser()->setAttribute("name", $resident->first_name);
          $this->getUser()->setAttribute("id", $resident->id);
          $this->getUser()->setAttribute("roomNo", $resident->room->roomNo);
          $this->getUser()->setFlash('notice', 'Logged in successfully');
          $this->redirect('calls/index');
        }
        else
        {
          $this->getUser()->setFlash('notice', 'Login failed! Check room number and password.');
          $this->redirect('auth/index');
        }
      }
    }
    }
  public function executeLogout(sfWebRequest $request)
  {
    $this->getUser()->setAuthenticated(false);
    $this->getUser()->setFlash('notice', 'Logged out successfully');
    $this->redirect('auth/index');
  }
}
