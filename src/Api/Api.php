<?php
namespace Api;

use Api\Route\Router;
use Api\Route\Dispatcher;

class Api
{

    /**
     * @var \Api\Route\Router
     */
    private $router;
    /**
     * @var \Api\Route\Dispatcher
     */
    private $dispatcher;

    public function __construct(Router $router, Dispatcher $dispatcher)
    {
        $this->router = $router;
        $this->dispatcher = $dispatcher;
    }

    public function run()
    {
        $routeInfo = $this->dispatcher->dispatchUrl(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI']
        );
        $this->router->handle($routeInfo);
    }
}
