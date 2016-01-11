<?php
namespace Api\Route\Strategy;

class Factory
{
    public function build($strategyId, $args=array())
    {
        $className = '';
        switch ($strategyId) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                $className = 'Api\Route\Strategy\RouteNotFound';
                break;

            case \FastRoute\Dispatcher::FOUND:
                $className = 'Api\Route\Strategy\RouteFound';
                break;
        }

        if(!class_exists($className)) {
            throw new \Exception("Strategy {$className} not found");
        }

        $reflection = new \ReflectionClass($className);
        $class = $reflection->newInstanceArgs($args);
        return $class;
    }
}