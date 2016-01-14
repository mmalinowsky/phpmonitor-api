<?php
namespace Api;

class Api
{
    
    private $router;
    private $dispatcher;

    public function __construct(Route\Router $router, Route\Dispatcher $dispatcher)
    {
        $this->router = $router;
        $this->dispatcher = $dispatcher;
    }

    public function run()
    {
        $routeInfo = $this->dispatcher->dispatchUrl($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
        $this->router->handle($routeInfo);
    }
}
