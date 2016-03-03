<?php
namespace Api\Controller;

use Api\Exception\Controller as ControllerException;

class Factory
{
    private $namespace = 'Api\Controller\\';

    public function build($name)
    {
        $className = $this->namespace.$name;
        if (! class_exists($className)) {
            throw new ControllerException($className.' class not found.');
        }
        return new $className;
    }
}
