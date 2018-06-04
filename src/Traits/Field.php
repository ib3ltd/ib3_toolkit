<?php

namespace Drupal\ib3_toolkit\Traits;

use Drupal\ib3_toolkit\Traits\Image;
use Drupal\ib3_toolkit\Traits\File;


trait Field {

  use Image;
  use File;

  protected function prepareTextFromField($entity, $arr)
  {
    extract($arr);
    return (is_array($entity)) ? $this->multi($entity, $field_name) : $this->single($entity, $field_name);
  }

  protected function preparePlotterFromField($entity, $arr)
  {
    extract($arr);
    return (is_array($entity)) ? $this->multiComplex($entity, $field_name) : $this->singleComplex($entity, $field_name);
  }

  protected function prepareIntegerFromField($entity, $arr)
  {
    extract($arr);
    return (is_array($entity)) ? $this->multi($entity, $field_name) : $this->single($entity, $field_name);
  }

  protected function prepareUrlFromField($entity, $arr)
  {
    extract($arr);
    return (is_array($entity)) ? $this->multiComplex($entity, $field_name) : $this->singleComplex($entity, $field_name);
  }

  protected function prepareGeoFromField($entity, $arr)
  {
    extract($arr);
    return (is_array($entity)) ? $this->multiComplex($entity, $field_name) : $this->singleComplex($entity, $field_name);
  }

  protected function prepareTaxonomyIdFromField($entity, $arr)
    {
      extract($arr);

      if (is_array($entity)) {
        return array_column($this->multiComplex($entity, $field_name), 'target_id');
      } else {
        $values = $this->singleComplex($entity, $field_name);
        if (is_array($values)) {
          $target_ids = [];
          foreach($values as $val) {
            $target_ids[] = $val['target_id'];
          }
          return $target_ids;
        } else {
          return $this->singleComplex($entity, $field_name)['target_id'];
        }
      }
    }



  protected function prepareImageFromField($entity, $arr)
  {
    extract($arr);
    return (is_array($entity)) ? $this->multiImage($entity, $field_name, $image_style, $image_style_high) : $this->singleImage($entity, $field_name, $image_style, $image_style_high);
  }

  protected function prepareFileFromField($entity, $arr)
  {
    extract($arr);
    return (is_array($entity)) ? $this->multiFile($entity, $field_name) : $this->singleFile($entity, $field_name);
  }

  private function multi($entity, $field_name)
  {
    foreach ($entity as $e) {
      $values[] = $this->single($e, $field_name);
    }
    return (isset($values)) ? $values : null;
  }

  private function single($entity, $field_name)
  {
    return (null !== $entity->get($field_name)) ? $entity->get($field_name)->value : null;
  }

  private function multiComplex($entity, $field_name)
  {
    foreach ($entity as $e) {
      $values[] = $this->singleComplex($e, $field_name);
    }
    return (isset($values)) ? $values : null;
  }

  private function singleComplex($entity, $field_name)
    {
     if (null !== $entity->get($field_name)) {
       if (array_key_exists(0, $entity->get($field_name)->getValue())) {
         if (count($entity->get($field_name)->getValue()) > 1) {
           return $entity->get($field_name)->getValue();
         } else {
           return $entity->get($field_name)->getValue()[0];
         }
       } else {
         return null;
       }
     } else {
       return null;
     }
    }
}
