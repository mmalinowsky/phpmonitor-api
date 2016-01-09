<?php
namespace Api\Controller;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testIfWeCanBuildValidController()
    {
        $factory = new Factory;
        $controller = $factory->build('Api\Controller\ServerInfo');
        $this->assertTrue(is_object($controller));
    }

    /**
     * @expectedException Api\Exception\Controller
    */
    public function testIfWeCanBuildNonExistentController()
    {
        $factory = new Factory;
        $controller = $factory->build('Api\Controller\InvalidController');
    }
}
