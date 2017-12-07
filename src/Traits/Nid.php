<?php

namespace Drupal\ib3_toolkit\Traits;

trait Nid {

  protected function prepareAliasFromNid($nid)
  {
    $alias_arr = \Drupal::service('path.alias_storage')->load(['source' => '/node/'.$nid]);
    return $alias_arr['alias'];
  }
}
