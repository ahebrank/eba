<?php

namespace Drupal\eba;

use Drupal\Core\StringTranslation\StringTranslationTrait;

use Drupal\eba\Helpers\EntityAttached;

/**
 * Defines dynamic permissions.
 *
 * @ingroup eck
 */
class PermissionsGenerator {
  use StringTranslationTrait;

  /**
   * Returns an array of entity type permissions.
   *
   * @return array
   *   The permissions.
   */
  public function entityPermissions() {
    $perms = [];
    
    // Generate permissions for possible attachments
    // loop through entity types
    $entity_info = EntityAttached::getEntityTypes();
    foreach ($entity_info as $entity_type => $entity_type_info) {
      if (EntityAttached::entityIsFieldable($entity_type_info)) {
        foreach (EntityAttached::getBundles($entity_type) as $bundle => $bundle_info) {
          $perms[self::getPermissionName($entity_type, $bundle)] = [
              'title' => $this->t('Attach blocks to %entity / %bundle',
                [
                  '%entity' => $entity_type_info->get('label'),
                  '%bundle' => $bundle_info['label'],
                ]),
            ];
        }
      }
    }

    return $perms;
  }
  
  /**
   * define the name of a permission based on entity type ID and bundle ID
  **/
  public static function getPermissionName($entity, $bundle) {
    return "attach blocks to {$entity} {$bundle}";
  }

}
