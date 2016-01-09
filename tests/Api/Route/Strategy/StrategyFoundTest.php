<?php
namespace Api\Route\Strategy;

class StrategyFoundTest extends \PHPUnit_Framework_TestCase
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

    /* need to mock... to be coded
    public function testPassingValidController()
    {
        $controller = 'ServerInfo';
        $method = 'getInfo';
        $parameters = array();
        $strategy = new StrategyFound($controller, $method, $parameters);
        $strategy->render();
    }
    */
}
