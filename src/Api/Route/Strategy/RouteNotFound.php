<?php
namespace Api\Route\Strategy;

use Api\Contract\Route\StrategyInterface;

class RouteNotFound implements StrategyInterface
{
    private $message = 'Routing Not found.';

    public function render()
    {
        header('Content-Type: application/json');
        echo json_encode(['error' => $this->message]);
    }
}
