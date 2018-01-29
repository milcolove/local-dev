<?php

namespace Drupal\hello\Access;
use Drupal\Core\Access\AccessCheckInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;


class HelloAccessCheck implements AccessCheckInterface {

  public function applies(Route $route) {
    return NULL;
  }
  
  public function access(Route $route, Request $request = NULL, AccountInterface $account) {
  	$nbr_heures = $route->getRequirement('_access_hello');

  	if ($account->isAnonymous()) {
  		return AccessResult::forbidden();

  	}
  	if ((REQUEST_TIME - $account->getAccount()->created > $nbr_heures * 3600)) {
  		return AccessResult::allowed()->cachePerUser()->setCacheMaxAge(60);
  		
  	}
  	return AccessResult::forbidden();
    
  }
}