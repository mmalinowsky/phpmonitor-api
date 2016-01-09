<?php
namespace Api\Format;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingExistingFormat()
    {
        $formatFactory = new Factory;
        $format = $formatFactory->createFormat('json');
        $this->assertTrue(is_object($format));
    }
    
    /**
    * @expectedException Api\Exception\Api
    */
    public function testBuildingNonExistentModule()
    {
        $formatFactory = new Factory;
        $format = $formatFactory->createFormat('unknownFormat');
    }
}
