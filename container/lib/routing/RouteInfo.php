<?php

namespace Plum\Routing;

use FastRoute\Dispatcher;
use Plum\Http\Request;
use Plum\View\Util\ViewUtil;

use function FastRoute\cachedDispatcher;

class RouteInfo {

  protected $uri;
  protected $http_method;

  private $dispatcher;
  private $info;

  public function __construct(\Closure $handlers) {
    $this->uri = request()->getUri();
    $this->http_method = request()->methodType();

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

  public function parameter(): ?array
  {
    return $this->info[2] ?? null;
  }

  public function dispatch(): void
  {
    $this->info = $this->dispatcher->dispatch($this->http_method, $this->uri);

    switch ($this->responseId()) {
      case Dispatcher::NOT_FOUND:
        ViewUtil::dispNotFound();
        break;
      case Dispatcher::METHOD_NOT_ALLOWED:
        echo 'Not Allowed Http Request';
        break;
      case Dispatcher::FOUND:
        $handler = $this->actionHandler();
        $param = $this->parameter();
        $req = Request::instance();

        list($class, $method) = explode("@", $handler, 2);
        echo (new $class())->$method($req, $param);
        break;
    }
  }
}
