<?php
namespace Api\Controller;

use Api\Exception\Controller as ControllerException;

class Factory
{
    public function build($name)
    {
        if (!class_exists($name)) {
            throw new ControllerException($name.' class not found.');
        }
        return new $name;
    }
}
