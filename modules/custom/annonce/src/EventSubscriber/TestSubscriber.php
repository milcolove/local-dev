<?php

namespace Drupal\annonce\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
use Drupal\Core\Session\AccountProxy;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Routing\CurrentRouteMatch;
//use \Drupal\Core\State\StateInterface;

/**
 * Class TestSubscriber.
 */
class TestSubscriber implements EventSubscriberInterface {

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;
  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;
  /**
   * Drupal\Core\Datetime\DateFormatter definition.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;
  /**
   * Constructs a new TestSubscriber object.
   */
  public function __construct(AccountProxy $current_user, Connection $database, DateFormatter $date_formatter, CurrentRouteMatch  $CurrentRouteMatch) {
    $this->currentUser = $current_user;
    $this->database = $database;
    $this->dateFormatter = $date_formatter;
    /*$this->requestStack = $request_stack;
    $this->routeMatches = new \SplObjectStorage();*/
    $this->CurrentRouteMatch  = $CurrentRouteMatch ;
   // $this->state = $state;
  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events['kernel.request'] = ['onRequest'];

    return $events;

  }

  /**
   * This method is called whenever the kernel.request event is
   * dispatched.
   *
   * @param GetResponseEvent $event
   */
  public function onRequest(Event $event) {
    
    //kint($this->CurrentRouteMatch);
   /* kint($this->database->insert('annonce_history')
      ->fields(array(
        'uid' => '1',
        'aid' => '1',
        'date' => '1516355567',
        )
        )->execute());*/
    
     if ($this->CurrentRouteMatch->getParameter('annonce')) {
       //drupal_set_message('entity annonce');

      $this->database->insert('annonce_history')
      ->fields(array(
        'aid' => $this->CurrentRouteMatch->getParameter('annonce')->id(),
        'uid'=>$this->currentUser->id(),
        'date' => time(),
        ))->execute(); 


     }
   //  afficher le nom de l'utilisateur sur toutes les pages
   //  $user = $this->currentUser->getAccountName();
  // drupal_set_message('My name is  '.$user, 'status', TRUE);
  }


}
