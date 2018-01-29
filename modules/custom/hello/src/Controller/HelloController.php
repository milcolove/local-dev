<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends ControllerBase {

	public function content($param) {

		/*On peut faire un kint cela nous permet de connaitre exactement quelle méthode utiliser sinon le mieux c'est de faire un tour sur l'api drupal */
		//kint($this->currentUser()); 
		//kint(\Drupal::currentUser());
		//kint(\Drupal::service('currentUser'))
		
		/*$message = $this->t('You are on the hello page. Your name is %username !', 
			array(
				'%username' => $this->currentUser()->getAccountName()
				'%param' => $param,
				));
		$build = array(
			'#markup' => $message);
		return $build;*/
		
	
     $user = $this->currentUser()->getAccountName();
     return ['#markup'=> $this->t('My name is :<strong> %nom </strong> this is my parameter: %param !',array('%nom'=>$user,'%param'=>$param))];
   
	}

	public function jsonFormat() {
			// solution 1
		/*$response = new Response(
			'json_encode(array([1, 2, 3, 4]))',
		Response::HTTP_OK,
		array('content-type' => 'application/json'));
		return $response;*/
		//solution 2
		$response = new Response();
		$response->setContent(json_encode(array('data' => 123,)));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
		// 3solution 3 
	//	return new JsonResponse(array('do', 'ré', 'mi'));


	}
}