<?php
namespace Api\Route\Strategy;

use League\Container\Container as Container;

class FactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testBuildingValidClass()
    {
        $container = new Container;
        $container->add('ControllerFactory', new \Api\Controller\Factory);
        $parameters['container'] = $container;
        $factory = new Factory;
        $strategy = $factory->build(\FastRoute\Dispatcher::FOUND, [null, null, $parameters]);
        $this->assertTrue(is_object($strategy));
    }

    /**
     * @expectedException \Exception
     */
    public function testBuildingInvalidStrategy()
    {
        $factory = new Factory;
        $strategy = $factory->build(421);
    }
}