<?php
namespace Api\Route\Strategy;

use Api\Contract\Route\StrategyInterface;

class RouteFound implements StrategyInterface
{

    private $controller;
    /**
     * @var string
     */
    private $method;
    /**
     * @var array
     */
    private $parameters;
    /**
     * @var \Api\Controller\Factory
     */
    private $controllerFactory;

    public function __construct($controller, $method, array $parameters)
    {
        $this->controller = $controller;
        $this->method = $method;
        $this->parameters = $parameters;
        $this->controllerFactory = $parameters['container']->get('ControllerFactory');
    }

    /**
     * Render Controller method
     */
    public function render()
    {
        $this->invokeController($this->controller, $this->method, $this->parameters);
    }

    /**
     * Invoke controller method
     *
     * @param string $controllerName
     * @param string $method
     * @param array $parameters
     */
    private function invokeController($controllerName, $method, array $parameters)
    {
        if ( ! $this->controllerFactory) {
            throw new \Exception('Controller Factory invalid.');
        }
        
        $controller = $this->controllerFactory->build($controllerName);

        if ( ! method_exists($controller, $method)) {
            throw new \Exception("Method called '{$method}' not found in '{$controllerName}'.");
        }
        call_user_func_array([$controller, $method], $parameters);
    }
}
