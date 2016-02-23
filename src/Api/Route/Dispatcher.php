<?php
namespace Api\Route;

class Dispatcher
{
    /**
     * @var \FastRoute\simpleDispatcher
     */
    private $dispatcher;

    public function __construct($dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Dispatch url
     *
     * @param string $method
     * @param string $request
     */
    public function dispatchUrl($method, $request)
    {
        $uri = rawurldecode(parse_url($request, PHP_URL_PATH));
        $routeInfo = $this->dispatcher->dispatch($method, $uri);
        return $routeInfo;
    }
}
