<?php

/**
 * @file
 * Contains \Drupal\es_unit\unitInterface.
 */

namespace Drupal\es_unit;

use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Provides an interface for defining unit entities.
 *
 * @ingroup es_unit
 */
interface unitInterface extends ContentEntityInterface {
  // Add get/set methods for your configuration properties here.

  /**
   * Gets the unit name.
   *
   * @return string
   *   Name of the unit.
   */
  public function getName();

  /**
   * Sets the unit name.
   *
   * @param string $name
   *   The unit name.
   *
   * @return \Drupal\es_unit\unitInterface
   *   The called unit entity.
   */
  public function setName($name);

}
