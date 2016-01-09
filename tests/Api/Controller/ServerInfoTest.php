<?php
namespace Api\Controller;

use Api\Module\Facade as ModuleFacade;
use Api\Format\Factory as FormatFactory;
use Api\Format\Processor as FormatProcessor;
use Api\Module\Factory as ModuleFactory;
use Api\Module\Composite as ModuleComposite;
use League\Container\Container as Container;

class ServerInfoTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInfo()
    {
        $_SERVER['SERVER_ADDR'] = '127.0.0.1';
        $formatMock = $this->getMockBuilder('Api\Format\FormatInterface')->getMock();
        $formatProcessor = $this->getMock('Api\Format\Processor', array('setHeader', 'renderData'));
        $formatProcessor->expects($this->any())->method('setHeader')->will($this->returnValue('set'));
        $container = new Container;
        $container->add('ModuleFacade', 'Api\Module\Facade')->withArgument(new \Api\Module\Factory)->withArgument(new \Api\Module\Composite);
        $container->add('FormatProcessor', $formatProcessor);
        $container->add('FormatFactory', 'Api\Format\Factory');
        $container->add('ControllerFactory', 'Api\Controller\Factory');

        $controller = new ServerInfo();
        $controller->getInfo($container, 'json');
    }

   
    public function testIfWeCanPassWhiteListWhenOurIpIsNotOnList()
    {
        $ip = 'localhost';
        $controller = new ServerInfo();
        $controllerRef = $this->setPropertyAccessible($controller, 'config');
        $controllerRef->getValue($controller)->whitelistEnabled = true;
        $controllerRef->getValue($controller)->whitelist = ['99.99.99.99'];
        $ret = $this->invokeMethod($controller, 'canUserPassWhiteList', array($ip));
        $this->assertFalse($ret);
    }

    public function testIfWeCanPassWhiteListWhenOurIpIsOnList()
    {
        $ip = 'localhost';
        $controller = new ServerInfo();
        $controllerRef = $this->setPropertyAccessible($controller, 'config');
        $controllerRef->getValue($controller)->whitelistEnabled = true;
        $controllerRef->getValue($controller)->whitelist = [$ip];
        $ret = $this->invokeMethod($controller, 'canUserPassWhiteList', array($ip));
        $this->assertTrue($ret);
    }

    public function testAddingModulesAndGettingData()
    {
        $moduleFacade = new ModuleFacade(new ModuleFactory, new ModuleComposite);
        $controller = new ServerInfo();
        $data = $this->invokeMethod($controller, 'addModulesAndGetData', array($moduleFacade, new \Api\Config));
        $this->assertArrayHasKey('hostname', $data);
    }

    public function invokeMethod(&$object, $methodName, $args = array())
    {
        $reflection = new \ReflectionClass($object);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $args);
    }

    public function setPropertyAccessible(&$object, $propertyName)
    {
        $reflection = new \ReflectionClass($object);
        $reflectionProperty = $reflection->getProperty($propertyName);
        $reflectionProperty->setAccessible(true);
        return $reflectionProperty;
    }
}
