<?php
namespace Api\Route\Strategy;

class RouteDefault extends StrategyAbstract
{
    private $message = 'Default routing strategy.';

    public function render()
    {
        header('Content-Type: application/json');
        echo json_encode(['error' => $this->message]);
    }
}
