<?php
namespace Api\Route;

use Symfony\Component\HttpFoundation\Request;

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
     * @param string $request
     */
    public function dispatchUrl(Request $request)
    {
        $method = $request->getMethod();
        $requestUri = $request->getRequestURI();
        $uri = rawurldecode(parse_url($requestUri, PHP_URL_PATH));
        $routeInfo = $this->dispatcher->dispatch($method, $uri);
        return $routeInfo;
    }
}
