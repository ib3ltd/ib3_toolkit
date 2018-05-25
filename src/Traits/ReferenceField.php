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

  protected function prepareParagraphEntityFromReferenceField($entity, $arr)
  {
    extract($arr);
    $values = [];

    if (get_class($entity->get($field_name)) == 'Drupal\Core\Field\EntityReferenceFieldItemList') {

      foreach($entity->get($field_name) as $e) {
        $uri = $e->entity->get($field_name)->entity->getFileUri();
          $url = file_url_transform_relative(file_create_url($uri));
            $values[] = [
              'url' => $url,
              'description' => array_key_exists('description', $e->getValue()) ? $e->getValue()['description'] : '',
            ];
      }
      return $values;
    } else {
      $e = $entity->get($field_name);
      return $e->entity;
    }
  }

  protected function prepareFileFromParagraphReferenceField($entity, $arr)
  {
    extract($arr);
    $paragraph = $this->fetchParagraph($entity, $paragraph_name);
    if (is_array($paragraph)) {

      $paragraphs = [];
      $x = 0;
      foreach ($paragraph as $para) {
        if(is_array($para)) {
          $paragraphs[$x] = [];
          $y = 0;
          foreach($para as $p) {
            $paragraphs[$x][$y] = $p ? $this->prepareParagraphEntityFromReferenceField($p, ['field_name' => $field_name]) : null;
            $y++;
          }
        } else {
          $paragraphs[$x] = $para ? $this->prepareParagraphEntityFromReferenceField($para, ['parent_field_name' => $parent_field_name, 'field_name' => $field_name]) : null;
        }
        $x++;
      }
      return $paragraphs;
    }
    $paragraphs[0] = $paragraph ? $this->prepareParagraphEntityFromReferenceField($paragraph, ['field_name' => $field_name]) : null;
    return $paragraphs;
  }
}
