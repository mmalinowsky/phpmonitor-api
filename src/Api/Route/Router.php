<?php
namespace Api\Route;

use Api\Controller\Factory as ControllerFactory;
use Api\Route\Strategy\Context as StrategyContext;

class Router
{
    
    private $controllerFactory;

    public function __construct($controllerFactory)
    {
        $this->controllerFactory = $controllerFactory;
    }

    public function handle($routeInfo)
    {
        $routeInfo = $this->prepareRouteInfo($routeInfo);
        $method = $routeInfo[1]['method'];
        $controller = $routeInfo[1]['controller'];
        $format = $routeInfo[2]['format'];
        $container = $routeInfo[1]['container'];
        $placeHolder = $routeInfo[2];
        $parameters = array_merge(['container' => $container], $placeHolder);

        $strategyContext = new StrategyContext($routeInfo[0], $controller, $method, $parameters);
        $strategyContext->strategyRender();
    }
    
    private function prepareRouteInfo($routeInfo)
    {
        isset($routeInfo[1]['method']) or $routeInfo[1]['method']  = null;
        isset($routeInfo[1]['controller']) or $routeInfo[1]['controller'] = null;
        isset($routeInfo[1]['container']) or $routeInfo[1]['container'] = null;
        isset($routeInfo[2]) or $routeInfo[2] = array();
        isset($routeInfo[2]['format']) or $routeInfo[2]['format'] = 'json';
        return $routeInfo;
    }
}
