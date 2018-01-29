<?php
namespace Drupal\hello\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HelloForm extends FormBase {
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
      return 'Hello formulaire';
    }

    //renvoyer la structure du formulaire
    public function buildForm(array $form, FormStateInterface $form_state) {
      // Champ destiné à afficher le résultat du calcul.
        if (isset($form_state->getRebuildInfo()['result'])) {
          $form['result'] = array(
            '#markup' => '<h2>' . $this->t('Result: ') . $form_state->getRebuildInfo()['result'] . '</h2>',
          );
        }

      $form['firstvalue'] = array(
        '#type' => 'textfield',
        '#title' => t('First value'),
        '#description'   => $this->t('Enter first value.'),
        '#required' => TRUE,
        '#ajax' =>array(
          'callback' => array($this, 'AjaxValidateNumeric'),
          'event' => 'change',
        ),
        '#suffix' => '<span id="error-message-firstvalue"></span>',
      );

      $form['operation'] = array(
        '#type' => 'radios',
        '#title' => t('Operation'),
        '#description' => t('choose your operation'),
        '#default_value' => 'addition',
        '#options' => array(
          'addition' => $this->t('addition'),
          'soustraction' => $this->t('soustraction'),
          'multiplication' => $this->t('multiplication'), 
          'division' => $this->t('division')),

      );
      $form['secondvalue'] = array(
        '#type' => 'textfield',
        '#title' => t('Second value'),
        '#description'   => $this->t('Enter second value.'),
        '#required' => TRUE,
        '#ajax' =>array(
          'callback' => array($this, 'AjaxValidateNumeric'),
          'event' => 'change',
        ),
        '#suffix' => '<span id="error-message-secondvalue"></span>',
      );

      $form['calculate'] = array(
        '#type' => 'submit',
        '#value' => t('calculer'),
      );
        
      return $form;
    }

    public function AjaxValidateNumeric(array &$form, FormStateInterface $form_state) {
      $response = new AjaxResponse();

        // print_r(json_encode($form_state->getTriggeringElement()));

        $field = $form_state->getTriggeringElement()['#name'];
        $css = ['border' => '2px solid green'];
        $message = $this->t('OK!');
        if (!is_numeric($form_state->getValue($field))) {
          $css = ['border' => '2px solid red'];
          $message = $this->t('%field must be numeric!', array('%field' => $form[$field]['#title']));
        }

        $response->AddCommand(new CssCommand("[name=$field]", $css));
        $response->AddCommand(new HtmlCommand('#error-message-' . $field, $message));

        return $response;
    }


    // La methode qui permet de faire toutes les vérification possibles
    public function validateForm(array &$form, FormStateInterface $form_state) {
      // Validation is optional.

      $valeurOption = $form_state->getValue('Operation');
      $nombre1 = $form_state->getValue('firstvalue');
      $nombre2 = $form_state->getValue('secondvalue');
      if (!is_numeric($nombre1)) {
          $form_state->setErrorByName('firstvalue', $this->t('First value must be numeric!'));
        }
        if (!is_numeric($nombre2)) {
          $form_state->setErrorByName('secondvalue', $this->t('Second value must be numeric!'));
        }
        if ($nombre2 == 0 && $valeurOption == 'division') {
          $form_state->setErrorByName('secondvalue', $this->t('Cannot divide by zero!'));
        }
          // A revoir après
      //  unset($form['result']);

      }


      public function submitForm(array &$form, FormStateInterface $form_state) {
     
      // Récupère la valeur des champs.
        $nombre1   = $form_state->getValue('firstvalue');
        $nombre2   = $form_state->getValue('secondvalue');
        $valeurOption = $form_state->getValue('operation');
          // A revoir 
        //$view      = $form_state->getValue('view');

        //$resultat = '';
        switch ($valeurOption) {
          case 'addition':
            $resultat = $nombre1 + $nombre2;
            break;
          case 'soustraction':
            $resultat = $nombre1 - $nombre2;
            break;
          case 'multiplication':
            $resultat = $nombre1 * $nombre2;
            break;
          case 'division':
            $resultat = $nombre1 / $nombre2;
            break;
        }

        /* // Redirection vers la route "hello.calculator.result".
        if ($view == 'redirect') {
          // On passe le résultat en paramètre dans l'url.
          $form_state->setRedirect('hello.calculator.result', array('result' => $resultat));
        }

        // On affiche le résultat dans le formulaire.
        if ($view == 'rebuild') {
          // On passe le résultat.
          $form_state->addRebuildInfo('result', $resultat);
          // Reconstruction du formulaire avec les valeurs saisies.
          $form_state->setRebuild();
        }
      */
        drupal_set_message( t('Result is :%result', array('%result' => $resultat)));
        
      }


}