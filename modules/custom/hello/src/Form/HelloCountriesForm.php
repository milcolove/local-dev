<?php
namespace Drupal\hello\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use SameerShelavale\PhpCountriesArray\CountriesArray ;

class HelloCountriesForm extends FormBase {

 protected $state;

      /**
       * {@inheritdoc}.
       */
      public function __construct(StateInterface $state) {
        $this->state = $state;
      }

      /**
       * {@inheritdoc}.
       */
      public static function create(ContainerInterface $container) {
        return new static(
          $container->get('state')
        );
      }

    // renvoyer des identifiant du formulaire
    public function getFormID() {
      return 'countries';
    }

    /**
       * {@inheritdoc}.
       */
    public function buildForm(array $form, FormStateInterface $form_state) {
      $countries = CountriesArray::get();
      $form['countries'] = array(
        '#type' => 'select',
        '#title' => $this->t('Choose your country'),
        '#options' => array(
        'countries' =>$countries),

        );
      $form['Validate'] = array(
        '#type' => 'submit',
        '#value' => t('Valider'),
      );
        
      return $form;
           
     // return $form ; // = [];
     // return parent::buildForm($form, $form_state);   
    }
   /**
       * {@inheritdoc}.
       */
      public function submitForm(array &$form, FormStateInterface $form_state) {
        

      }
     
      

}