<?php

namespace Drupal\ib3_toolkit\Interfaces;

/**
 * Interface TaxonomyInterface.
 */
interface TaxonomyInterface {

  public function getTaxonomyTreeByName($taxonomy_name);

  public function getTermById($taxonomy_name, $term_id);

  public function getTermParentsById($taxonomy_name, $term_id, $descend_tree = false);

  public function getTermsByDepth($taxonomy_name, $depth);
}
