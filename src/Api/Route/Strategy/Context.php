<?php
namespace Api\Route\Strategy;

class Context
{
    private $strategy = null;

    public function __construct($strategyId, $controller, $method, $parameters)
    {
        switch ($strategyId) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                $this->strategy = new RouteNotFound();
                break;

            case \FastRoute\Dispatcher::FOUND:
                $this->strategy = new RouteFound($controller, $method, $parameters);
                break;

            default:
                $this->strategy = new RouteDefault();
                break;
        }
    }

    public function strategyRender()
    {
        $this->strategy->render();
    }
}
