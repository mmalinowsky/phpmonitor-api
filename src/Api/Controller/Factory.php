<?php
namespace Api\Controller;

class Factory
{
    public function build($name)
    {
        if (!class_exists($name)) {
            throw new \Exception($name.' class not found.');
        }
        return new $name;
    }
}
