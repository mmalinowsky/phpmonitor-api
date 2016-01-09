<?php
namespace Api\Route\Strategy;

class ContextTest extends \PHPUnit_Framework_TestCase
{
    protected $container;
    protected $controller;
    protected $method;
    protected $formatClass;
    protected $parameters;

    public function setUp()
    {
        $this->container = null;
        $this->controller = 'ServerInfo';
        $this->method = 'getInfo';
        $this->formatClass = null;
        $this->parameters = null;
    }

    public function testStrategyNotFoundWithNonExistingController()
    {
        $strategyId = \FastRoute\Dispatcher::NOT_FOUND;
        $controller = 'NonExistentController';
        $method = 'unknown';
        $context = new Context($strategyId, $this->controller, $this->method, $this->formatClass, $this->parameters);
        $contextRef = $this->setPropertyAccessible($context, 'strategy');
        $this->assertTrue(get_class($contextRef->getValue($context)) == 'Api\Route\Strategy\RouteNotFound');
    }

    public function testStrategyNotFoundWithExistingControllerAndValidMethod()
    {
        $strategyId = \FastRoute\Dispatcher::NOT_FOUND;
        $controller = 'ServerInfo';
        $method = 'getInfo';
        $context = new Context($strategyId, $this->controller, $this->method, $this->formatClass, $this->parameters);
        $contextRef = $this->setPropertyAccessible($context, 'strategy');
        $this->assertTrue(get_class($contextRef->getValue($context)) == 'Api\Route\Strategy\RouteNotFound');
    }

    public function testStrategyFound()
    {
        $strategyId = \FastRoute\Dispatcher::FOUND;
        $context = new Context($strategyId, $this->controller, $this->method, $this->formatClass, $this->parameters);
        $contextRef = $this->setPropertyAccessible($context, 'strategy');
        $this->assertTrue(get_class($contextRef->getValue($context)) == 'Api\Route\Strategy\RouteFound');
    }

    public function testStrategyDefault()
    {
        $strategyId = 1275675;
        $context = new Context($strategyId, $this->controller, $this->method, $this->formatClass, $this->parameters);
        $contextRef = $this->setPropertyAccessible($context, 'strategy');
        $this->assertTrue(get_class($contextRef->getValue($context)) == 'Api\Route\Strategy\RouteDefault');
    }

    public function setPropertyAccessible(&$object, $propertyName)
    {
        $reflection = new \ReflectionClass($object);
        $reflectionProperty = $reflection->getProperty($propertyName);
        $reflectionProperty->setAccessible(true);
        return $reflectionProperty;
    }
}
