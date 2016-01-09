<?php
namespace Api\Route;

class Dispatcher
{
    private $dispatcher;

    public function __construct($dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function dispatch($method, $request)
    {
        $uri = rawurldecode(parse_url($request, PHP_URL_PATH));
        $routeInfo = $this->dispatcher->dispatch($method, $uri);
        return $routeInfo;
    }
}
