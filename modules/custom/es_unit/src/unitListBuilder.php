<?php

/**
 * @file
 * Contains \Drupal\es_unit\unitListBuilder.
 */

namespace Drupal\es_unit;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of "Unit" entities.
 *
 * @ingroup es_unit
 */
class unitListBuilder extends EntityListBuilder {
  use LinkGeneratorTrait;
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Unit ID');
    $header['brand'] = $this->t('Brand');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}Status
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\es_unit\Entity\unitEntity */
    $row['id'] = $entity->id();
    $row['brand'] = $this->l(
      $entity->label(),
      new Url(
        'entity.unit.canonical', array(
          'unit' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
