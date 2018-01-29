<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'TEST' block.
 *
 * @Block(
 *  id = "test",
 *  admin_label = @Translation("Test"),
 * )
 */
class TEST extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['test']['#markup'] = 'Implement TEST.';

    return $build;
  }

}
