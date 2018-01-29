<?php

namespace Drupal\hello\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Ce code permet d'empêcher d'accèder à la liste des modules
   // kint($route = $collection->get('user.login'));
    
    // Always deny access to all user
    // Note that the second parameter of setRequirement() is a string.
    /*if ($route = $collection->get('system.modules_list')) {
      $route->setRequirement('_access', 'FALSE');
    }*/
  }

}