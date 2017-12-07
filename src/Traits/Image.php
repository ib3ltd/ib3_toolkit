<?php

namespace Drupal\ib3_toolkit\Traits;

use Drupal\image\Entity\ImageStyle;

trait Image {

  protected function multiImage($entity, $field_name, $image_style, $image_style_high)
  {
    $images = [];
    foreach ($entity as $e) {
      $images[count($images)] = $this->singleImage($e, $field_name, $image_style, $image_style_high);
    }
    return (count($images) > 0) ? $images : null;
  }

  protected function singleImage($entity, $field_name, $image_style, $image_style_high)
  {
    foreach($entity->get($field_name) as $e) {
      $uri = $e->entity->getFileUri();
      $images[] = [
        'src' => file_url_transform_relative(ImageStyle::load($image_style)->buildUrl($uri)),
        'retina' => file_url_transform_relative(ImageStyle::load($image_style_high)->buildUrl($uri)),
        'alt' => $e->getValue()['alt'],
      ];
    }
    return isset($images) ? $images : null;
  }

}
