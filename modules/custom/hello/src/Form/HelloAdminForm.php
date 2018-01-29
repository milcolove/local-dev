<?php
namespace Drupal\hello\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
//Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HelloAdminForm extends ConfigFormBase {

 protected $entityTypeManager;


      /**
       * {@inheritdoc}.
       */
      public function __construct(EntityTypeManagerInterface $entityTypeManager) {
        $this->entityTypeManager = $entityTypeManager;
      }

      /**
       * {@inheritdoc}.
       */
      public static function create(ContainerInterface $container) {
        return new static(
          $container->get('entity_type.manager')
        );
      }


    // renvoyer des identifiant du formulaire
    public function getFormID() {
      return 'Admin_config_form';
    }

     /**
       * {@inheritdoc}.
       */
    public function getEditableConfigNames() {
      return ['hello.config'];
     

      }

    /**
       * {@inheritdoc}.
       */
    public function buildForm(array $form, FormStateInterface $form_state) {
      $form['color'] = array(
        '#type' => 'select',
        '#title' => $this->t('Choose a block color'),
        '#options' => array(
          'red' => $this->t('Red'),
          'blue' => $this->t('Blue'),
          'orange' => $this->t('Orange'),
          ),

        '#default_value' => $this->config('hello.config')->get('color'),
        );
           
     // return $form ; // = [];
      return parent::buildForm($form, $form_state);   
    }
   /**
       * {@inheritdoc}.
       */
      public function submitForm(array &$form, FormStateInterface $form_state) {
         //return parent::submitForm($form, $form_state);

        $values = $form_state->getValue('color');
        $this->config('hello.config')
        ->set('color', $values)
        ->save();
        
       // \Drupal::service('entityTypeManager')->getViewBuilder('block')->resetCache();
       $this->entityTypeManager->getViewBuilder('block')->resetCache();
       return parent::submitForm($form, $form_state);

      }
     
      

}