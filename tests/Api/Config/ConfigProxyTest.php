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
}
