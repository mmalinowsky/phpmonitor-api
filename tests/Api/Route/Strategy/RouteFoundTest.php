<?php
namespace Api\Route\Strategy;

use League\Container\Container;
use Api\Controller\Factory as ControllerFactory;

class RouteFoundTest extends \PHPUnit_Framework_TestCase
{

    private $container;
    private $parameters;

    protected function setUp()
    {
        $this->container = new Container;
        $this->container->add('ControllerFactory', new ControllerFactory);
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
        $parameters = ['container' => $this->container, 'format' => 'json'];
        $strategy = new RouteFound($controller, $method, $parameters);
        $strategy->render();
    }
}