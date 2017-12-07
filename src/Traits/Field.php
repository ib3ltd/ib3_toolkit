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
      return $this->singleComplex($entity, $field_name)['target_id'];
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
    return (null !== $entity->get($field_name)) ? $entity->get($field_name)->getValue()[0] : null;
  }
}
