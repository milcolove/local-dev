<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;



/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "hello_block",
 *   admin_label = @Translation("Hello block"),
 *   category = @Translation("Hello World"),
 * )
 */
class HelloBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
  					//perso/
 // $timestamp = \Drupal::time()->getCurrentTime();
  //ligne1//$datetoday = format_date($timestamp,'custom','G : \hi : s\s');

 //meme que ligne 1/$datetoday = \Drupal::service('date.formatter')->format($timestamp,'custom','G : \hi : s\s');

  				//Prof
  
 //  $datetoday = \Drupal::service('date.formatter')->format(time(),'html_time');
   //prof
   $this->dateFormatter =  \Drupal::service('date.formatter');
   $this->currentUser =  \Drupal::service('current_user');
  	$build = array(
  		'#markup' => $this->t('Welcome %name. It is %time.', array(
  			'%name' => $this->currentUser->getAccountName(),
  			'%time' =>$this->dateFormatter->format(REQUEST_TIME, 'custom', 'H:i: s\s'),
  			)
  		),
  		'#cache'=> array(
					   'keys'=>['hello_block'],
					   'contexts'=> ['user'],
					   'tags'=> ['user:'.$this->currentUser->id()],
					   'max-age'=>'1000',
		   		),
	
  		);
  		return $build;

   /*return $build_1 = ['#markup' => $this->t('Bienvenue sur notre site. Il est %datejour', array('%datejour'=>$datetoday)),
				     '#cache'=>[
					   'keys'=>['build_1'],
					   'contexts'=> ['user'],
					   'tags'=> ['user:'.$this->currentUser-id()],
					   'max-age'=>'1000',

		   ],
		  ];*/
  }
}
  
