<?php

namespace Drupal\ib3_toolkit\Traits;

trait File {

  protected function multiFile($entity, $field_name)
  {
    $files = [];
    foreach ($entity as $e) {
      $files[count($files)] = $this->singleFile($e, $field_name);
    }
    return (count($files) > 0) ? $files : null;
  }

  protected function singleFile($entity, $field_name)
  {
    foreach($entity->get($field_name) as $e) {
      $uri = $e->entity->getFileUri();
      $fid = $e->entity->id();
      $url = file_url_transform_relative(file_create_url($uri));
      $files[] = [
        'fid' => $fid,
        'url' => $url,
        'description' => $e->getValue()['description'],
      ];
    }
    return isset($files) ? $files : null;
  }

}
