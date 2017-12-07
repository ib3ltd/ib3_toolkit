<?php

namespace Drupal\ib3_toolkit\Traits;

//use Drupal\ib3_toolkit\Traits\Field;
use Drupal\ib3_toolkit\Traits\Nid;

trait Node {

  use Nid;
  //use Field;

  protected function prepareTextFromNode($entity, $arr)
  {
    return $this->prepareTextFromField($entity, $arr);
  }

  protected function prepareAliasFromNode($node, $arr = null)
  {
    $nid = $node->nid->value;
    $alias = $this->prepareAliasFromNid($nid);
    return $alias;
  }

  protected function prepareNidFromNode($node, $arr = null)
  {
    return $node->nid->value;
  }
}
