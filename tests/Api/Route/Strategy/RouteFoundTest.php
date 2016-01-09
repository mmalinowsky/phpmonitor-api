<?php
namespace Api\Route\Strategy;

use League\Container\Container;

class RouteFoundTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Exception
    */
    public function testPassingNonExistentController()
    {
        $controller = 'SomeNonExistentController';
        $method = 'NonExistentMethod';
        $parameters = array();
        $strategy = new RouteFound($controller, $method, $parameters);
        $strategy->render();
    }

    /**
     * @expectedException \Exception
    */
    public function testPassingExistentControllerWithNonValidMethod()
    {
        $controller = 'ServerInfo';
        $method = 'NonExistentMethod';
        $parameters = array();
        $strategy = new RouteFound($controller, $method, $parameters);
        $strategy->render();
    }

    /**
     * @expectedException \Exception
    */
    public function testPassingExistentControllerWithValidMethodWithoutProperParameters()
    {
        $controller = 'ServerInfo';
        $method = 'getInfo';
        $parameters = array();
        $strategy = new RouteFound($controller, $method, $parameters);
        $strategy->render();
    }
}