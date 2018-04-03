<?php

namespace Drupal\ib3_toolkit\Services;

use Drupal\ib3_toolkit\Interfaces\TaxonomyInterface;

/**
 * Class TaxonomyService.
 */
class TaxonomyService implements TaxonomyInterface {

  public function getTaxonomyTreeByName($taxonomy_name)
  {
    $terms =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($taxonomy_name);
    $tids = [];
    $entries = null;

    foreach ($terms as $term) {
        $tids[$term->tid] = [
          'id' => $term->tid,
          'name' => $term->name,
          'description' => $term->description__value,
          'depth' => $term->depth,
          'parent' => $term->parents[0],
        ];
    }

    return $tids;
  }

  public function getTermById($taxonomy_name, $term_id)
  {
    $terms = $this->getTaxonomyTreeByName($taxonomy_name);
    return is_numeric($term_id) ? $terms[$term_id] : null;
  }

  public function getTermsByDepth($taxonomy_name, $depth)
  {
    $terms = $this->getTaxonomyTreeByName($taxonomy_name);
    $depth = $depth;

    $level_terms = null;

    foreach ($terms as $term) {
      if ($term['depth'] == $depth) {
        $level_terms[] = $term;
      }
    }

    return $level_terms;
  }

  public function getTermParentsById($taxonomy_name, $term_id, $descend_tree = false)
  {
    $terms = $this->getTaxonomyTreeByName($taxonomy_name);
    $term = $terms[$term_id];
    $depth = $term['depth'];

    if ($depth === 0) return null;

    $parent_terms = [];

    do {
      $term = $terms[$term['parent']];
      $parent_terms[] = $term;
      $depth--;
    } while ($depth > 0);

    return ($descend_tree) ? array_reverse($parent_terms, false) : $parent_terms;
  }

}
