<?php

namespace Drupal\ib3_toolkit\Services;

use Drupal\ib3_toolkit\Interfaces\MenuInterface;

/**
 * Class MenuService.
 */
class MenuService implements MenuInterface {

  public function getByName($menu_name)
  {
    $menu_tree = \Drupal::menuTree();

    $parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name);
    $tree = $menu_tree->load($menu_name, $parameters);

    $manipulators = [
      ['callable' => 'menu.default_tree_manipulators:checkAccess'],
      ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
    ];

    $tree = $menu_tree->transform($tree, $manipulators);
    $menu = $menu_tree->build($tree);

    $entries = [];

    foreach ($menu['#items'] as $item) {

      if ($item['url']->isRouted()) {
        $alias = \Drupal::service('path.alias_storage')->load(['source' => '/node/'.$item['url']->getRouteParameters()['node']]);
        $url = $alias['alias'];
      } else {
        $url = $item['url']->getUri();
      }

      $entries[] = [
        'title' => $item['title'],
        'url' => $url,
        'state' => $item['in_active_trail'] ? 'active' : '',
      ];
    }

    return $entries;
  }

}
