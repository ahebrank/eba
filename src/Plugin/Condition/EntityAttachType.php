<?php

namespace Drupal\eba\Plugin\Condition;

use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\Entity\ContentEntityType;

/**
 * Provides a 'Entity Attach Type' condition.
 *
 * @Condition(
 *   id = "entity_attach_type",
 *   label = @Translation("Attach to Entity")
 * )
 */
class EntityAttachType extends ConditionPluginBase {

  public function defaultConfiguration() {
    return array('eba' => '') + parent::defaultConfiguration();
  }


  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {

    $config = $this->configuration['eba'];

    $entity_info = \Drupal::entityManager()->getDefinitions();
    foreach ($entity_info as $entity_type => $entity_type_info) {
      if ($entity_type_info instanceof ContentEntityType) {
        $entity_type_label = $entity_type_info->get('label');

        $potential_element = [
          '#type' => 'checkboxes',
          '#title' => $entity_type_label,
          '#options' => [],
          '#default_value' => isset($config['bundles'][$entity_type]) ? $config['bundles'][$entity_type] : [],
        ];

        foreach (\Drupal::entityManager()->getBundleInfo($entity_type) as $bundle => $bundle_info) {
          // need some access checks but skipping for now
          $potential_element['#options'][$bundle] = $bundle_info['label'];
        }

        if (!empty($potential_element['#options'])) {
          $parent_element[$entity_type] = $potential_element;
        }
      }
    }

    // If there were no allowed options then do not make changes to the form.
    $children = Element::children($parent_element);
    if (!empty($children)) {
      $form['eba'] = [];
      $form['eba']['bundles'] = $parent_element;

      $form['eba']['respect_visibility'] = array(
        '#type' => 'checkbox',
        '#title' => t('Respect block visibility settings'),
        '#default_value' => isset($config['respect_visibility'])?  $config['respect_visibility'] : FALSE,
        '#description' => t('Only display the block on entities if it is not restricted by other visibility settings.'),
      );
    }

    return parent::buildConfigurationForm($form, $form_state);
  }

  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['eba'] = array_filter($form_state->getValue('eba'));
    parent::submitConfigurationForm($form, $form_state);
  }

  public function evaluate() {
    if (empty($this->configuration['eba']) && !$this->isNegated()) {
      return TRUE;
    }

    // TODO: how to determine the entity
    // $node = $this->getContextValue('node');
    // return !empty($this->configuration['bundles'][$node->getType()]);
    return TRUE;
  }

  // TODO: how to summarize conditional settings
  public function summary() {
    return '';
  }
}
