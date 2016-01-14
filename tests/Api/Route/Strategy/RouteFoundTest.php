<?php
namespace Api\Route\Strategy;

use League\Container\Container;

class RouteFoundTest extends \PHPUnit_Framework_TestCase
{

    private $container;
    private $parameters;

    protected function setUp()
    {
        $this->container = new Container;
        $this->container->add('ControllerFactory', new \Api\Controller\Factory);
        $this->parameters['container'] = $this->container;
    }

    /**
     * @expectedException \Exception
    */
    public function testPassingNonExistentController()
    {
        $controller = 'SomeNonExistentController';
        $method = 'NonExistentMethod';
        $strategy = new RouteFound($controller, $method, $this->parameters);
        $strategy->render();
    }

    /**
     * @expectedException \Exception
    */
    public function testPassingExistentControllerWithNonValidMethod()
    {
        $controller = 'ServerInfo';
        $method = 'nonValidMethod';
        $strategy = new RouteFound($controller, $method, $this->parameters);
        $strategy->render();
    }

    /**
     * @expectedException \Exception
    */
    public function testPassingExistentControllerWithValidMethodWithoutProperParameters()
    {
        $controller = 'ServerInfo';
        $method = 'getInfo';
        $strategy = new RouteFound($controller, $method, $this->parameters);
        $strategy->render();
    }
}