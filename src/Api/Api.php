<?php
namespace Api;

use Api\Route\Router;
use Api\Route\Dispatcher;
use Symfony\Component\HttpFoundation\Request;

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
    /**
     * @var use Symfony\Component\HttpFoundation\Request
     */
    private $request;
    public function __construct(Router $router, Dispatcher $dispatcher)
    {
        $this->router = $router;
        $this->dispatcher = $dispatcher;
    }

    public function run(Request $request)
    {
        $routeInfo = $this->dispatcher->dispatchUrl($request);
        $this->router->handle($routeInfo);
    }
}
