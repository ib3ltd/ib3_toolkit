<?php

namespace Drupal\ib3_toolkit\Interfaces;

/**
 * Interface ItemsInterface.
 */
interface ItemsInterface {

  public function process($filter_definitions, $field_definitions);

  public function getItems();

  public function getItem($idx);
}
