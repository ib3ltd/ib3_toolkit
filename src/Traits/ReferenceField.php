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

  protected function prepareTaxonomyIdFromReferenceField($entity, $arr)
  {
    extract($arr);
    $e = $entity->get($parent_field_name);
    return $this->prepareTaxonomyIdFromField($e->entity, $arr);
  }

  protected function prepareEntityFromReferenceField($entity, $arr)
  {
    extract($arr);
    $values = [];
    if (get_class($entity->get($parent_field_name)) == 'Drupal\Core\Field\EntityReferenceFieldItemList') {
      foreach($entity->get($parent_field_name) as $e) {
        $values[] = $e->entity;
      }
      return $values;
    } else {
      $e = $entity->get($parent_field_name);
      return $e->entity;
    }
  }
}
