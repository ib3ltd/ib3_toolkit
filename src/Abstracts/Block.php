<?php

namespace Drupal\ib3_toolkit\Abstracts;

use Drupal\Core\Block\BlockBase;
use Drupal\ib3_toolkit\Interfaces\ItemsInterface;
use Drupal\ib3_toolkit\Interfaces\TaxonomyInterface;
use Drupal\ib3_toolkit\Interfaces\MenuInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\PrivateTempStoreFactory;
use Symfony\Component\HttpFoundation\RequestStack;


abstract class Block extends BlockBase implements ContainerFactoryPluginInterface {

  protected $taxonomyService;
  protected $itemsService;
  protected $menuService;
  protected $sessionStore;
  protected $requestStack;

  protected static $config;

  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    ItemsInterface $itemsInterface,
    TaxonomyInterface $taxonomyInterface,
    MenuInterface $menuInterface,
    PrivateTempStoreFactory $session_store_factory,
    RequestStack $request_stack
  )
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $theme = self::$config->get('theme');
    $session = self::$config->get('session') ? self::$config->get('session') : self::$config->get('theme');
    $this->sessionStore = $session_store_factory->get($session);
    $this->itemsService = new $itemsInterface;
    $this->taxonomyService = new $taxonomyInterface;
    $this->menuService = new $menuInterface;
    $this->requestStack = $request_stack;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    $config = \Drupal::config($plugin_definition['provider'].'.settings');
    self::$config = $config;
    $toolkit = self::$config->get('toolkit');

    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get($toolkit[0]),
      $container->get($toolkit[1]),
      $container->get($toolkit[2]),
      $container->get('user.private_tempstore'),
      $container->get('request_stack')
    );
  }
}
