<?php

/**
 * @file
 * Contains \Drupal\es_unit\unitAccessControlHandler.
 */

namespace Drupal\es_unit;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the unit entity.
 *
 * @see \Drupal\es_unit\Entity\unitEntity.
 */
class unitAccessControlHandler extends EntityAccessControlHandler {
  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\es_unit\unitInterface $entity */
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view published unit entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit unit entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete unit entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add unit entities');
  }

}
