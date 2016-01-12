<?php
namespace Api\Route\Strategy;

class FactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testBuildingValidClass()
    {
        $factory = new Factory;
        $strategy = $factory->build(\FastRoute\Dispatcher::FOUND, [null, null, null]);
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