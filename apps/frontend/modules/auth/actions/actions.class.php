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
   * Executes the login-action. Display form, process form and choose correct language
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    /* greet the user in his mother tongue */
    $preferedCulture = $request->getPreferredCulture(array('de'));
    if( ! $this->getUser()->isAuthenticated())
    {
      $this->getUser()->setCulture($preferedCulture);
    }

    $this->form = new LoginForm();
    
    if($request->isMethod('post'))
    {
      $resident = $this->authenticate($request, $this->form);
      if( !($resident instanceof Residents)) {
        $this->getUser()->setFlash('error', 'auth.login.failed');
        $this->redirect('auth/index');
      }
      else 
      {
        /* respect the users choice of language (UNIMPLEMENTED see settings form!) */
        if($resident->getCulture()) {
          $this->getUser()->setCulture($resident->getCulture());
        }
                
        $this->getUser()->setFlash('notice', 'auth.login.successful');
        $this->redirect('calls/index');
      }
    }
  }

  /**
   * Authenticate a user with the details given by the params
   *
   * @param sfWebRequest $request
   * @param sfForm $form
   * @return Residents resident that is now authenticated
   * @return NULL if authentication failed
  */
  private function authenticate(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($this->form->getName()));
    if ($form->isValid())
    {
      $residentsTable = Doctrine_Core::getTable('Residents');
      try
      {
        $resident = $residentsTable->findByRoomNo($this->form->getValue('roomNo'));
      } catch(Exception $e) {
        return NULL;
      }
      
      if(null !== $resident && $resident->getPassword() === md5($this->form->getValue('password')))
      {
        $this->getUser()->setAuthenticated(true);

        // Set basic attributes of the signed in user.
        $this->getUser()->setAttribute("name", $resident->getFirstName());
        $this->getUser()->setAttribute("id", $resident->getId());
        $this->getUser()->setAttribute("roomNo", $resident['Rooms']['room_no']);

        if($resident->getHekphone())
        {
          // user is a HEKPhone staff member
          $this->getUser()->addCredential('hekphone');
        }
        
        return $resident;
      }
    }

    return NULL;
  }
  
  public function executeLogout(sfWebRequest $request)
  {
    $this->getUser()->setAuthenticated(false);
    $this->getUser()->setFlash('notice', 'auth.logout.successful');
    $this->redirect('auth/index');
  }
}
