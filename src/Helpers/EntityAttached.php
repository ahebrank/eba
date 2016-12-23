<?php

namespace Drupal\eba\Helpers;

use Drupal\Core\Entity\ContentEntityType;
use Drupal\eba\PermissionsGenerator;

class EntityAttached {
  
  /**
   * check if a particular entity is content
  **/
  static function entityIsFieldable($info) {
    return ($info instanceof ContentEntityType);
  }
  
  /**
   * check if a particular entity bundle is attachable
  **/
  static function bundleIsAccessible($entity_id, $bundle_id) {
    $perm = PermissionsGenerator::getPermissionName($entity_id, $bundle_id);
    return \Drupal::currentUser()->hasPermission($perm);
  }
  
  /**
   * wrap getBundleInfo()
  **/
  static function getBundles($entity_type) {
    return \Drupal::service('entity_type.bundle.info')->getBundleInfo($entity_type);
  }
  
  /**
   * wrap getDefinitions()
  **/
  static function getEntityTypes() {
    return \Drupal::service('entity_type.manager')->getDefinitions();
  }

}
