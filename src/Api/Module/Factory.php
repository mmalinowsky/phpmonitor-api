<?php
namespace Api\Module;

use Api\Exception\Api as ApiException;

class Factory
{

    const MODULE_NAMESPACE = '\Api\Module\\';
    const CONTRACT_NAMESPACE = '\Api\Contract\Module\\';

    public function build($className, $system, $args = [])
    {
        $systemPrefix = 'Linux';
        if (strtoupper(substr($system, 0, 3)) === 'WIN') {
            $systemPrefix = 'Windows';
        }

        $className = self::MODULE_NAMESPACE.$systemPrefix.'\\'.$className;
        if ( ! class_exists($className)) {
            throw new ApiException('Invalid module given');
        }

        $reflectionClass = new \ReflectionClass($className);
        if ( ! $reflectionClass->isSubclassOf(self::CONTRACT_NAMESPACE.'ModuleInterface')) {
            throw new ApiException('Not valid implementation of Module');
        }

        return $reflectionClass->newInstanceArgs($args);
    }
}
