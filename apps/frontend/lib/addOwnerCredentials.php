<?php
/**
 * This filter checks wheter the user tries to access his own details/calls/settings
 * or the ones of another user by specifying the request parameter 'residentid'
 * (have a look at the routing.yml)
 * If he accesses his own, the credential "owner" is added temporarly.
 *
 * @author hannes
 *
 */
class addOwnerCredentials extends sfFilter
{
// Credits go to tilmann at stackoverflow for his snippet
  function execute($filterChain)
  {
    $context = $this->getContext();
    $request = $context->getRequest();
    $user = $context->getUser();

    // Add owner credential for current user or remove if he has it but shouldn't
    if ( ! $request->hasParameter('residentid')){
      // no residentid => the user tries to access his own details
      $user->addCredential('owner');
    }
    elseif ($request->getParameter('residentid') == $user->getAttribute('id')) {
      // the user tries to access his own details by specifying his own residentid
      $user->addCredential('owner');
    }
    elseif ($user->hasCredential('owner')) {
      $user->removeCredential('owner');
    }

    // Continue down normal filterChain
    $filterChain->execute($filterChain);

    // On the way back, before rendering, remove owner credential again
    // The code after the call to $filterChain->execute() executes after the
    // action execution and before the rendering.
    if ($user->hasCredential('owner')) {
      $user->removeCredential('owner');
    }
  }

}
