<?php

namespace Drupal\pets_owners_storage\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'PetsOwnersStorageBlock' block.
 *
 * @Block(
 *  id = "pets_owners_storage_block",
 *  admin_label = @Translation("PetsOwnersStorage block"),
 * )
 */
class PetsOwnersStorageBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    ////$build = [];
    //$build['mydata_block']['#markup'] = 'Implement MydataBlock.';

    $form = \Drupal::formBuilder()->getForm('Drupal\pets_owners_storage\Form\PetsOwnersStorageForm');

    return $form;
  }

}
