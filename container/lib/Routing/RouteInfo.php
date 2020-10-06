<?php

namespace Plum\Routing;

use FastRoute\Dispatcher;
use Plum\View\ViewTrait;

use function FastRoute\cachedDispatcher;

class RouteInfo {
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

  public function getInfo(): array
  {
    return $this->info;
  }

  public function responseId(): int
  {
    return $this->info[0];
  }

  public function actionHandler(): string
  {
    return $this->info[1];
  }

  public function routeParameters(): ?\Plum\Routing\RouteParameters
  {
    $parameters = $this->info[2] ?? null;
    $rp = new RouteParameters($parameters);
    return $rp;
  }

  public function dispatch(): void
  {
    $this->info = $this->dispatcher->dispatch($this->http_method, $this->uri);

    switch ($this->responseId()) {
      case Dispatcher::NOT_FOUND:
        $this->dispNotFound();
        break;
      case Dispatcher::METHOD_NOT_ALLOWED:
        echo 'Not Allowed Http Request';
        break;
      case Dispatcher::FOUND:
        $handler = $this->actionHandler();
        $params = $this->routeParameters();

        list($class, $method) = explode("@", $handler, 2);
        echo (new $class())->$method(request(), $params);
        break;
    }
  }
}
