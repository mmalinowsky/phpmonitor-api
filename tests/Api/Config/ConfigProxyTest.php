<?php
namespace Api\Config;

class ConfigProxyTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->config = new ConfigProxy('Config.json');
    }

    public function extensionProvider()
    {
        return
        [
            ['file.json', 'json'],
            ['file.xml', 'xml'],
            ['file.file.ExT', 'ext'],
        ];
    }

    public function testJsonSetAndGet()
    {
        $this->config->someRandomProp = 'test';
        $this->assertSame($this->config->someRandomProp, 'test');
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
        $extension = 'json';
        $ret = $this->invokeMethod($this->config, 'searchForConfigClass', [$extension]);
        $this->assertSame('Api\Config\ConfigJson', $ret);
    }

    /**
     * @expectedException \Exception
     */
    public function testSearchForInvalidExtension()
    {
        $extension = 'xml';
        $ret = $this->invokeMethod($this->config, 'searchForExtension', [$extension]);
    }

    /**
     * @dataProvider extensionProvider
     */
    public function testGetFileExtension($filename, $extension)
    {
        $ret = $this->invokeMethod($this->config, 'getFileExtension', [$filename]);
        $this->assertSame($ret, $extension);
    }

    public function invokeMethod(&$object, $methodName, $args = array())
    {
        $reflection = new \ReflectionClass($object);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $args);
    }
}
