<?php
namespace Api\Route\Strategy;

class RouteFound implements StrategyInterface
{
    private $controller;
    private $method;
    private $parameters;
    private $controllerFactory;

    public function __construct($controller, $method, $parameters)
    {
        $this->controller = $controller;
        $this->method = $method;
        $this->parameters = $parameters;
        $this->controllerFactory = $parameters['container']->get('ControllerFactory');
    }

    public function render()
    {
            $this->invokeController($this->controller, $this->method, $this->parameters);
    }

    private function invokeController($controllerName, $method, $parameters)
    {
        if (!$this->controllerFactory) {
            throw new \Exception('Controller Factory invalid.');
        }
        
        $controller = $this->controllerFactory->build($controllerName);

        if (!method_exists($controller, $method)) {
            throw new \Exception("Method called '{$method}' not found in '{$controllerName}'.");
        }
        call_user_func_array([$controller, $method], $parameters);
    }
}
