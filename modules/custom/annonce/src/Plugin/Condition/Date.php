<?php

namespace Drupal\annonce\Plugin\Condition;

use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\Context\ContextDefinition;

/**
* Provides a 'Date condition' condition to enable a condition based in module selected status.
*
* @Condition(
*   id = "date_condition",
*   label = @Translation("Date condition"),
* )
*
*/
class Date extends ConditionPluginBase {

/**
* {@inheritdoc}
*/
public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
{
    return new static(
    $configuration,
    $plugin_id,
    $plugin_definition
    );
}

/**
 * Creates a new DateCondition object.
 *
 * @param array $configuration
 *   The plugin configuration, i.e. an array with configuration values keyed
 *   by configuration option name. The special key 'context' may be used to
 *   initialize the defined contexts by setting it to an array of context
 *   values keyed by context names.
 * @param string $plugin_id
 *   The plugin_id for the plugin instance.
 * @param mixed $plugin_definition
 *   The plugin implementation definition.
 */
 public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
 }

 /**
   * {@inheritdoc}
   */
 public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
     // Sort all modules by their names.
     $modules = system_rebuild_module_data();
     uasort($modules, 'system_sort_modules_by_info_name');

     /*$options = [NULL => t('Select a module')];
     foreach($modules as $module_id => $module) {
         $options[$module_id] = $module->info['name'];
     }
*/
     $form['datestart'] = [
         '#type' => 'date',
         '#title' => $this->t('Starting date'),
         '#default_value' => $this->configuration['datestart'],
        // '#options' => $options,
       //  '#description' => $this->t('Module selected status will be use to evaluate condition.'),
     ];
     $form['dateend'] = [
         '#type' => 'date',
         '#title' => $this->t('Ending date'),
         '#default_value' => $this->configuration['dateend'],
         //'#options' => $options,
       //  '#description' => $this->t('Module selected status will be use to evaluate condition.'),
     ];
     $form['negate']['#access'] = FALSE;
     return $form;

     //return parent::buildConfigurationForm($form, $form_state);
 }

/**
 * {@inheritdoc}
 */
 public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
     //$this->configuration['module'] = $form_state->getValue('module');
   //  parent::submitConfigurationForm($form, $form_state);
     $this->configuration['datestart'] =$form_state->getValue('datestart');
     $this->configuration['dateend'] =$form_state->getValue('dateend');
    parent::submitConfigurationForm($form, $form_state);
 }

/**
 * {@inheritdoc}
 */
 public function defaultConfiguration() {
    return array('datestart' => array(), 'dateend' => array()) + parent::defaultConfiguration();
 }

/**
  * Evaluates the condition and returns TRUE or FALSE accordingly.
  *
  * @return bool
  *   TRUE if the condition has been met, FALSE otherwise.
  */
  public function evaluate() {
    $dateStart = strtotime($this->configuration['datestart']);
    $dateEnd = strtotime($this->configuration['dateend']);

   // Aucune date.
   if (empty($dateStart) && empty($dateEnd)) {
     return TRUE;
   }
   // Date de début uniquement.
   if (!empty($dateStart) && empty($dateEnd)) {
     if ($dateStart <= REQUEST_TIME) {
       return TRUE;
     }
     else return FALSE;
   }
   // Date de fin uniquement.
   if (empty($dateStart) && !empty($dateEnd)) {
     if ($dateEnd >= REQUEST_TIME) {
       return TRUE;
     }
   }
   // Date de début et de fin.
   if (!empty($dateStart) && !empty($dateEnd)) {
     if ($dateStart <= REQUEST_TIME && $dateEnd >= REQUEST_TIME) {
       return TRUE;
     }
   }

   else return FALSE;
 }


/**
 * Provides a human readable summary of the condition's configuration.
 */
 public function summary()
 {
     $module = $this->getContextValue('module');
     $modules = system_rebuild_module_data();

     $status = ($modules[$module]->status)?t('enabled'):t('disabled');

     return t('The module @module is @status.', ['@module' => $module, '@status' => $status]);
 }

}
