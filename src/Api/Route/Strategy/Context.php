<?php
namespace Api\Route\Strategy;

class Context
{
    private $strategy;

    public function __construct($strategyId, $strategyFactory, $controller, $method, $parameters)
    {
        switch ($strategyId) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                $this->strategy = $strategyFactory->build(\FastRoute\Dispatcher::NOT_FOUND);
                break;

            case \FastRoute\Dispatcher::FOUND:
                $this->strategy = $strategyFactory->build(\FastRoute\Dispatcher::FOUND,
                    [$controller,
                    $method,
                    $parameters]
                );
                break;
        }
    }

    public function strategyRender()
    {
        $this->strategy->render();
    }
}
