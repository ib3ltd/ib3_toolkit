<?php

namespace Drupal\ib3_toolkit\Traits;

use Drupal\ib3_toolkit\Traits\Field;

trait Paragraph {

  use Field;

  protected function prepareTextFromParagraph($entity, $arr)
  {
    extract($arr);
    $paragraph = $this->fetchParagraph($entity, $paragraph_name);
    return $paragraph ? $this->prepareTextFromField($paragraph, ['field_name' => $field_name]) : null;
  }

  protected function prepareUrlFromParagraph($entity, $arr)
  {
    extract($arr);
    $paragraph = $this->fetchParagraph($entity, $paragraph_name);
    return $paragraph ? $this->prepareUrlFromField($paragraph, ['field_name' => $field_name]) : null;
  }

  protected function prepareGeoFromParagraph($entity, $arr)
  {
    extract($arr);
    $paragraph = $this->fetchParagraph($entity, $paragraph_name);
    return $paragraph ? $this->prepareGeoFromField($paragraph, ['field_name' => $field_name]) : null;
  }

  protected function prepareTaxonomyIdFromParagraph($entity, $arr)
  {
    extract($arr);
    $paragraph = $this->fetchParagraph($entity, $paragraph_name);
    return $paragraph ? $this->prepareTaxonomyIdFromField($paragraph, ['field_name' => $field_name]) : null;
  }

  protected function prepareImageFromParagraph($entity, $arr)
  {
    extract($arr);
    $paragraph = $this->fetchParagraph($entity, $paragraph_name);
    return $paragraph ? $this->prepareImageFromField($paragraph, ['field_name' => $field_name, 'image_style' => $image_style, 'image_style_high' => $image_style_high]) : null;
  }

  protected function prepareFileFromParagraph($entity, $arr)
  {
    extract($arr);
    $paragraph = $this->fetchParagraph($entity, $paragraph_name);
    return $paragraph ? $this->prepareFileFromField($paragraph, ['field_name' => $field_name]) : null;
  }
}
