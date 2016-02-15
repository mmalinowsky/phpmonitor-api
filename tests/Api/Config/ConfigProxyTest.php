<?php
namespace Api\Config;

class ConfigProxyTest extends \PHPUnit_Framework_TestCase
{

    public function testJsonSetAndGet()
    {
        $config = new ConfigProxy('Config.json');
        $config->someRandomProp = 'test';
        $this->assertSame($config->someRandomProp, 'test');
    }

    /**
     * @expectedException \Exception
     */
    public function testInvalidFormat()
    {
        $config = new ConfigProxy('Config.dvw');
    }

    public function testSearchForValidExtension()
    {
        $config = new ConfigProxy('Config.json');
        $extension = 'json';
        $ret = $this->invokeMethod($config, 'searchForConfigName', [$extension]);
        $this->assertSame('Api\Config\ConfigJson', $ret);
    }

    /**
     * @expectedException \Exception
     */
    public function testSearchForInvalidExtension()
    {
        $config = new ConfigProxy('Config.json');
        $extension = 'xml';
        $ret = $this->invokeMethod($config, 'searchForExtension', [$extension]);
    }


    public function invokeMethod(&$object, $methodName, $args = array())
    {
        $reflection = new \ReflectionClass($object);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $args);
    }
}
