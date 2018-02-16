<?php

namespace Drupal\ib3_toolkit\Services;

use Drupal\ib3_toolkit\Interfaces\MenuInterface;

/**
 * Class MenuService.
 */
class MenuService implements MenuInterface {

  private function resolveTree($menu_tree, $tree)
  {
    $entries = [];

    foreach ($tree as $element) {

      $link = $element->link;

      $url = $link->getUrlObject();

      $entry = [
        'title' => $element->link->getTitle(),
        'url' => null,
        'state' => $element->inActiveTrail ? 'active' : '',
        'children' => null,
      ];

      if ($url->isRouted()){
        $entry['url'] = $url->toString();
      } else {
        $entry['url'] = $url->getUri();
      }

      if ($element->hasChildren) {
        $entry['children'] = $this->resolveTree($menu_tree, $element->subtree);
      }

      $entries[] = $entry;
    }

    return $entries;
  }

  public function getByName($menu_name)
  {
    $menu_tree = \Drupal::menuTree();

    $parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name);

    $parameters->setMinDepth(0);
    $parameters->setMaxDepth(20);

    $tree = $menu_tree->load($menu_name, $parameters);

    $manipulators = [
      ['callable' => 'menu.default_tree_manipulators:checkAccess'],
      ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
    ];

    $tree = $menu_tree->transform($tree, $manipulators);
    $entries = $this->resolveTree($menu_tree, $tree);

    return $entries;
  }

}
