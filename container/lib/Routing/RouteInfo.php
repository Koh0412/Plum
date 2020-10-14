<?php

namespace Plum\Routing;

use FastRoute\Dispatcher;
use Plum\Foundation\BaseService;
use Plum\View\ViewTrait;

use function FastRoute\cachedDispatcher;

class RouteInfo extends BaseService {
  use ViewTrait;

  protected $uri;
  protected $http_method;

  /** @var \FastRoute\Dispatcher $dispatcher */
  private $dispatcher;
  private $info;

  public function __construct(\Closure $handlers) {
    $this->uri = request()->getUri();
    $this->http_method = request()->method();

    $this->dispatcher = cachedDispatcher($handlers, [
      'cacheFile' => __DIR__ . '/route.cache',
      'cacheDisabled' => true
    ]);
  }

  /**
   * return info about fast route dispatcher
   *
   * @return array
   */
  public function getInfo(): array
  {
    return $this->info;
  }

  /**
   * response id that return from the dispatcher
   *
   * @return integer
   */
  public function responseId(): int
  {
    return $this->info[0];
  }

  /**
   * return action hadnler that is specified to routing
   *
   * @return string
   */
  public function actionHandler(): string
  {
    return $this->info[1];
  }

  /**
   * return route parameter that specify in routing file
   *
   * @return \Plum\Routing\RouteParameters|null
   */
  public function routeParameters(): ?\Plum\Routing\RouteParameters
  {
    $parameters = $this->info[2] ?? null;
    $rp = new RouteParameters($parameters);
    return $rp;
  }

  /**
   * dispatch routing. this is sepalating by response id
   *
   * @return void
   */
  public function dispatch(): void
  {
    $this->info = $this->dispatcher->dispatch($this->http_method, $this->uri);

    $map = array(
      Dispatcher::NOT_FOUND => function() { $this->dispNotFound(); },
      Dispatcher::METHOD_NOT_ALLOWED => function() { echo 'Not Allowed Http Request'; },
      Dispatcher::FOUND => function() { $this->foundPageHandler(); }
    );

    $this->lookForMap($this->responseId(), $map);
  }

  /**
   * run handling when server is found a page that is defining
   *
   * @return void
   */
  private function foundPageHandler(): void
  {
    $handler = $this->actionHandler();
    $params = $this->routeParameters();

    list($class, $method) = explode(static::METHOD_DELIMITER, $handler, 2);
    echo (new $class(request()))->$method($params);
  }
}
