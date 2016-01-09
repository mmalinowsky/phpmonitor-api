<?php
namespace Api\Route\Strategy;

class RouteNotFound extends StrategyAbstract
{
    private $message = 'Routing Not found.';

    public function render()
    {
        header('Content-Type: application/json');
        echo json_encode(['error' => $this->message]);
    }
}
