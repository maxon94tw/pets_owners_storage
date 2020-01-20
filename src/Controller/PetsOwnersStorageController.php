<?php

namespace Drupal\pets_owners_storage\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class PetsOwnersStorageController.
 *
 * @package Drupal\pets_owners_storage\Controller
 */
class PetsOwnersStorageController extends ControllerBase {

  /**
   * Display.
   *
   * @return string
   * Return Hello string.
   */
  public function display() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('This page contain all inforamtion about pets owners')
    ];
  }

}
