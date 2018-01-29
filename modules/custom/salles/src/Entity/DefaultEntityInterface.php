<?php

namespace Drupal\salles\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Salles entity entities.
 *
 * @ingroup salles
 */
interface DefaultEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Salles entity name.
   *
   * @return string
   *   Name of the Salles entity.
   */
  public function getName();

  /**
   * Sets the Salles entity name.
   *
   * @param string $name
   *   The Salles entity name.
   *
   * @return \Drupal\salles\Entity\DefaultEntityInterface
   *   The called Salles entity entity.
   */
  public function setName($name);

  /**
   * Gets the Salles entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Salles entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Salles entity creation timestamp.
   *
   * @param int $timestamp
   *   The Salles entity creation timestamp.
   *
   * @return \Drupal\salles\Entity\DefaultEntityInterface
   *   The called Salles entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Salles entity published status indicator.
   *
   * Unpublished Salles entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Salles entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Salles entity.
   *
   * @param bool $published
   *   TRUE to set this Salles entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\salles\Entity\DefaultEntityInterface
   *   The called Salles entity entity.
   */
  public function setPublished($published);

}
