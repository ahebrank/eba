<?php

namespace Drupal\eba\Helpers;

use Drupal\block\Entity\Block;

class AttachedBlocks {
  
  /**
   * return a list of all blocks that might be attached to entities
   * as [ $block_id => [ $entity => $bundle ]]
  **/
  static function getAllAttached() {
    $attached = [];
    
    $block_manager = \Drupal::service('plugin.manager.block');
    $blocks = \Drupal::entityQuery('block')
      ->execute();
    
    foreach ($blocks as $id) {
      $block = Block::load($id);
      if ($settings = $block->getThirdPartySetting('eba', 'bundles')) {
        foreach ($settings as $entity => $bundles) {
          $attached_bundles = array_values(array_filter($bundles));
          if ($attached_bundles) {
            $attached[$id][$entity] = $attached_bundles;
          }
        }
      }
    }
    return $attached;
  }
  
  /**
   * return render blocks for a given entity/bundle
   * as [ $block_id => $build ]
  **/
  static function getAttachedTo($entity, $bundle) {
    $blocks = [];
    $all_attached = self::getAllAttached();
    foreach ($all_attached as $block_id => $attached_entities) {
      foreach ($attached_entities as $attached_entity => $attached_bundles) {
        if ($entity == $attached_entity && in_array($bundle, $attached_bundles)) {
          $blocks[$block_id] = self::render($block_id);
        }
      }
    }
    return $blocks;
  }
  
  /**
   * make a block id into a render array
  **/
  static function render($block_id) {
    $block = Block::load($block_id);
    $build = \Drupal::service('entity_type.manager')->getViewBuilder('block')
      ->view($block);
    return $build;
  }
  
  /**
   * return a consistent field name
  **/
  static function getFieldName($id) {
    return 'eba_' . $id;
  }
  
  /**
   * return a consistent field label
  **/
  static function getFieldLabel($id) {
    return 'EBA: ' . $id;
  }
  
  /**
   * return a consistent field description
  **/
  static function getFieldDescription($id) {
    return 'EBA: ' . $id . ' block';
  }
}
