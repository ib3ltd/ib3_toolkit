<?php

namespace Drupal\ib3_toolkit\Traits;

use Drupal\ib3_toolkit\Traits\Field;

trait Paragraph {

  use Field;

  protected function prepareIntegerFromParagraph($entity, $arr)
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
            $paragraphs[$x][$y] = $p ? $this->prepareIntegerFromField($p, ['field_name' => $field_name]) : null;
            $y++;
          }
        } else {
          $paragraphs[$x] = $para ? $this->prepareIntegerFromField($para, ['field_name' => $field_name]) : null;
        }
        $x++;
      }
      return $paragraphs;
    }
    return $paragraph ? $this->prepareIntegerFromField($paragraph, ['field_name' => $field_name]) : null;
  }

  protected function prepareTextFromParagraph($entity, $arr)
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
            $paragraphs[$x][$y] = $p ? $this->prepareTextFromField($p, ['field_name' => $field_name]) : null;
            $y++;
          }
        } else {
          $paragraphs[$x] = $para ? $this->prepareTextFromField($para, ['field_name' => $field_name]) : null;
        }
        $x++;
      }
      return $paragraphs;
    }
    return $paragraph ? $this->prepareTextFromField($paragraph, ['field_name' => $field_name]) : null;
  }

  protected function preparePlotterFromParagraph($entity, $arr)
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
            $paragraphs[$x][$y] = $p ? $this->preparePlotterFromField($p, ['field_name' => $field_name]) : null;
            $y++;
          }
        } else {
          $paragraphs[$x] = $para ? $this->preparePlotterFromField($para, ['field_name' => $field_name]) : null;
        }
        $x++;
      }
      return $paragraphs;
    }
    return $paragraph ? $this->preparePlotterFromField($paragraph, ['field_name' => $field_name]) : null;
  }

  protected function prepareUrlFromParagraph($entity, $arr)
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
            $paragraphs[$x][$y] = $p ? $this->prepareUrlFromField($p, ['field_name' => $field_name]) : null;
            $y++;
          }
        } else {
          $paragraphs[$x] = $para ? $this->prepareUrlFromField($para, ['field_name' => $field_name]) : null;
        }
        $x++;
      }
      return $paragraphs;
    }
    return $paragraph ? $this->prepareUrlFromField($paragraph, ['field_name' => $field_name]) : null;
  }

  protected function prepareGeoFromParagraph($entity, $arr)
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
            $paragraphs[$x][$y] = $p ? $this->prepareGeoFromField($p, ['field_name' => $field_name]) : null;
            $y++;
          }
        } else {
          $paragraphs[$x] = $para ? $this->prepareGeoFromField($para, ['field_name' => $field_name]) : null;
        }
        $x++;
      }
      return $paragraphs;
    }
    return $paragraph ? $this->prepareGeoFromField($paragraph, ['field_name' => $field_name]) : null;
  }

  protected function prepareTaxonomyIdFromParagraph($entity, $arr)
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
            $paragraphs[$x][$y] = $p ? $this->prepareTaxonomyIdFromField($p, ['field_name' => $field_name]) : null;
            $y++;
          }
        } else {
          $paragraphs[$x] = $para ? $this->prepareTaxonomyIdFromField($para, ['field_name' => $field_name]) : null;
        }
        $x++;
      }
      return $paragraphs;
    }
    return $paragraph ? $this->prepareTaxonomyIdFromField($paragraph, ['field_name' => $field_name]) : null;
  }

  protected function prepareImageFromParagraph($entity, $arr)
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
            $paragraphs[$x][$y] = $p ? $this->prepareImageFromField($p, ['field_name' => $field_name, 'image_style' => $image_style, 'image_style_high' => $image_style_high]) : null;
            $y++;
          }
        } else {
          $paragraphs[$x] = $para ? $this->prepareImageFromField($para, ['field_name' => $field_name, 'image_style' => $image_style, 'image_style_high' => $image_style_high]) : null;
        }
        $x++;
      }
      return $paragraphs;
    }
    return $paragraph ? $this->prepareImageFromField($paragraph, ['field_name' => $field_name, 'image_style' => $image_style, 'image_style_high' => $image_style_high]) : null;
  }

  protected function prepareFileFromParagraph($entity, $arr)
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
            $paragraphs[$x][$y] = $p ? $this->prepareFileFromField($p, ['field_name' => $field_name]) : null;
            $y++;
          }
        } else {
          $paragraphs[$x] = $para ? $this->prepareFileFromField($para, ['field_name' => $field_name]) : null;
        }
        $x++;
      }
      return $paragraphs;
    }
    return $paragraph ? $this->prepareFileFromField($paragraph, ['field_name' => $field_name]) : null;
  }
}
