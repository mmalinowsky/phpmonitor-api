<?php
namespace Api\Route;

use Api\Route\Strategy\Context as StrategyContext;

class Router
{

    /**
     * @var \League\Container\Container;
     */
    private $container;

    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * Handle route info
     *
     * @param array $routeInfo
     */
    public function handle($routeInfo)
    {
        $routeInfo = $this->prepareRouteInfo($routeInfo);
        $method = $routeInfo[1]['method'];
        $controller = $routeInfo[1]['controller'];
        $placeHolder = $routeInfo[2];
        $parameters = array_merge(['container' => $this->container], $placeHolder);
        $strategyContext = new StrategyContext($routeInfo[0], $controller, $method, $parameters);
        $strategyContext->strategyRender();
    }
    
    /**
     * Prepare route and fill with default value
     *
     * @param  array $routeInfo
     * @return array $routeInfo
     */
    private function prepareRouteInfo($routeInfo)
    {
        isset($routeInfo[1]['method']) || $routeInfo[1]['method']  = null;
        isset($routeInfo[1]['controller']) || $routeInfo[1]['controller'] = null;
        isset($routeInfo[2]) || $routeInfo[2] = [];
        isset($routeInfo[2]['format']) || $routeInfo[2]['format'] = 'json';
        return $routeInfo;
    }
}
