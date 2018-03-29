<?php

namespace Drupal\ib3_toolkit\Traits;

//use Drupal\ib3_toolkit\Traits\Field;

trait ReferenceField {

  //use Field;

  protected function prepareFileFromReferenceField($entity, $arr)
  {
    extract($arr);
    $values = null;
    foreach($entity->get($parent_field_name) as $e) {
      $value = $this->prepareFileFromField($e->entity, $arr);
      if ($value) {
        $values[] = $value;
      }
    }
    return $values;
  }
}
