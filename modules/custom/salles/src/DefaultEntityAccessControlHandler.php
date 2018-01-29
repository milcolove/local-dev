<?php

namespace Drupal\salles;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Salles entity entity.
 *
 * @see \Drupal\salles\Entity\DefaultEntity.
 */
class DefaultEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\salles\Entity\DefaultEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished salles entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published salles entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit salles entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete salles entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add salles entity entities');
  }

}
