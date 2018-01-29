<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;



/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "SessionsActives",
 *   admin_label = @Translation("Sessions actives block"),
 *   admin_label = @Translation("Sessions actives"),
 * )
 */
class SessionsActivesBlock extends BlockBase {

 /**
   * {@inheritdoc}
   */
  public function build() {
    /*$build = [];
    $build['donnees']['#markup'] = 'Il y a actuellement N sessions actives.';*/

  
   
    //kint(\Drupal::service('database')->select($table='sessions'));
   // kint(\Drupal::service('database')->select($table='sessions')->countQuery()->execute()->fetchField());
   				 // MON CODE //
    $this->database =  \Drupal::service('database');
    $build = array(
  		'#markup' => $this->t('Il y a actuellement %nbresessions sessions actives', array(
  			'%nbresessions' => $this->database->select($table='sessions')->countQuery()->execute()->fetchField(),
  			)
  		),
  		'#cache'=> array(
					   'keys'=>['hello:sessions'],
					   'tags'=> ['sessions'],
					
		   		),
  		
	
  		);


    return $build;
  
  }
  /*kint(Drupal::currentUser());
  Drupal::currentUser()->hasPermission('name of permission');*/
// La même vérification pour un utilisateur précis.
//$account = User::load('3');
//$account->hasPermission('name of permission');*/
  protected function blockAccess(AccountInterface $account){
   
  
     //return AccesResult::allowed();
     return AccessResult::allowedIfHasPermission($account, 'access hello');
  }
   

}
  
