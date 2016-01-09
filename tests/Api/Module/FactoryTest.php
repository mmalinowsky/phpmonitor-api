<?php
namespace Api\Module;

use Api\Module\Factory;
use Api\Exception\Api as ApiException;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingValidModule()
    {
        $moduleFactory = new Factory;
        $module = $moduleFactory->build('System', 'Linux', array('google.com'));
        $this->assertTrue(is_object($module));
    }
    
    /**
    * @expectedException Api\Exception\Api
    */
    public function testBuildingNonExistentModule()
    {
        $moduleFactory = new Factory;
        $moduleFactory->build('someNonExistentModule', 'Linux');
    }
}
