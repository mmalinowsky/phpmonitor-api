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
        $routeInfo = $this->dispatcher->dispatch();
        $this->router->handle($routeInfo);
    }
}
