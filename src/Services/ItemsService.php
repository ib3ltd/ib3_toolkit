<?php

namespace Drupal\ib3_toolkit\Services;

use Drupal\ib3_toolkit\Interfaces\ItemsInterface;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\ib3_toolkit\Traits\Items;

/**
 * Class ItemsService.
 */
class ItemsService implements ItemsInterface {

  use Items;

  private $nids;
  private $nodes;
  private $items;
  private $field_definitions;
  private $filter_definitions;
  private $prepared_item;

  public function process($filter_definitions, $field_definitions)
  {
    $this->clearItems();

    $this->setFilterDefinitions($filter_definitions);
    $this->setFieldDefinitions($field_definitions);

    $this->fetchNids();

    if ($this->hasNids()) $this->fetchNodes();
    if ($this->hasNodes()) $this->prepareItems();
  }

  public function getItems()
  {
    return $this->items;
  }

  public function getItem($idx)
  {
    return $this->items[$idx];
  }

  private function clearItems()
  {
    $this->items = null;
  }

  private function prepareItems()
  {
    for ($idx = 0; $idx < $this->nodeCount(); $idx++) {
      $this->prepareItem($idx);
      $this->addItem($this->getPreparedItem());
    }
    return $this->itemCount();
  }

  private function hasNids()
  {
    return $this->getNids() ? true : false;
  }

  private function fetchNodes()
  {
    $nodes = Node::loadMultiple($this->getNids());
    $this->setNodes($nodes);

    return $this->nodeCount();
  }

  private function hasNodes()
  {
    return $this->getNodes() ? true : false;
  }

  private function setNids($nids)
  {
    $this->nids = array_values($nids);
  }

  private function nidCount()
  {
    return $this->hasNids() ? count($this->getNids()) : 0;
  }

  private function getNode($idx)
  {
    return $this->nodes[$idx];
  }

  private function nodeCount()
  {
    return $this->hasNodes() ? count($this->getNodes()) : 0;
  }

  private function itemCount()
  {
    return $this->hasItems() ? count($this->getItems()) : 0;
  }

  private function addItem($item)
  {
    $this->items[] = $item;
  }

  private function prepareItem($idx)
  {
    $node = $this->getNode($idx);
    $this->resetPreparedItem();
    $this->processFieldDefinitions($node);
  }

  private function setFieldDefinitions($field_definitions)
  {
    $this->field_definitions = $field_definitions;
  }

  private function processFieldDefinition($node, $definition)
  {
    $params = isset($definition[1]) ? $definition[1] : null;

    if (is_array($params) && array_key_exists('children', $params)) {
      $field_values = [
        'parent' => call_user_func([$this, $definition[0]], $node, $params),
        'children' => [],
      ];
    } else {
      $field_values = call_user_func([$this, $definition[0]], $node, $params);
    }

    if ($params === null) return $field_values;
    if (!array_key_exists('children', $params)) return $field_values;

    foreach ($params['children'] as $field_name => $definition) {
      $field_rows = $this->processFieldDefinition($node, $definition);
      $field_values['children'][$field_name] = $field_rows;
    }

    return $field_values;
  }

  private function definitionHasChildren($definition)
  {
    return isset($definition[1]) && array_key_exists('children', $definition[1]) ? true : false;
  }

  private function gatherChildren($key, $parent, $children, $iteration = null)
  {
    $row = [];
    $row[$key] = $parent;
    foreach ($children as $child_name => $child) {
      $row[$child_name] = is_null($iteration) ? $child : $child[$iteration];
    }
    return $row;
  }

  private function processFieldDefinitions($node)
  {
    $field_definitions = $this->getFieldDefinitions();

    foreach ($field_definitions as $key => $definition)
    {
      $field = $this->processFieldDefinition($node, $definition);

      if (!$this->definitionHasChildren($definition)) {
        $this->addPreparedItemField($key, $field);
        continue;
      }

      $parent_child_fields = [];
      $x = 0;

      if (is_array($field['parent'])) {
        foreach ($field['parent'] as $parent) {
          $parent_child_fields[] = $this->gatherChildren($key, $parent, $field['children'], $x);
          $x++;
        }
      } else {
        $parent_child_fields[] = $this->gatherChildren($key, $field['parent'], $field['children']);
      }

      $field = $parent_child_fields;
      $this->addPreparedItemField($key, $field);
    }
  }

  private function getFieldDefinitions()
  {
    return $this->field_definitions;
  }

  private function setFilterDefinitions($filter_definitions)
  {
    for($x = 0; $x < count($filter_definitions); $x++) {
      for($y = 0; $y < count($filter_definitions[$x]); $y++) {
        if ($filter_definitions[$x][$y] == '<current>') {
          $filter_definitions[$x][$y] = \Drupal::routeMatch()->getRawParameter('node');
        }
      }
    }
    $this->filter_definitions = $filter_definitions;
  }

  private function getFilterDefinitions()
  {
    return $this->filter_definitions;
  }

  private function fetchNids()
  {
    $query = \Drupal::entityQuery('node');

    foreach ($this->getFilterDefinitions() as $definition) {
      if (!isset($definition[3])) $definition[3] = null;
      $query->{$definition[0]}($definition[1], $definition[2], $definition[3]);
    }

    $nids = $query->execute();

    $this->setNids($nids);
    return $this->nidCount();
  }

  private function fetchParagraph($node, $field_name)
  {
    if (!$this->hasParagraph($node, $field_name)) return null;
    if (!$node->{$field_name}->target_id) return null;

    if ($node->{$field_name}->count() == 1) {
      return Paragraph::load($node->{$field_name}->target_id);
    }

    $target_ids = [];

    foreach($node->{$field_name} as $p) {
      $target_ids[] = $p->target_id;
    }

    $paragraph = Paragraph::loadMultiple($target_ids);

    return $paragraph;
  }

  private function hasParagraph($node, $field_name)
  {
    return isset($node->{$field_name}) ? true : false;
  }

  private function hasItems()
  {
    return $this->getItems() ? true : false;
  }

  private function getNids()
  {
    return $this->nids;
  }

  private function setNodes($nodes)
  {
    $this->nodes = array_values($nodes);
  }

  private function getNodes()
  {
    return $this->nodes;
  }

  private function resetPreparedItem()
  {
    $this->prepared_item = null;
  }

  private function getPreparedItem()
  {
    return $this->prepared_item;
  }

  private function addPreparedItemField($key, $value)
  {
    $this->prepared_item[$key] = $value;
  }

}
