<?php
namespace Api\Module;

class CompositeTest extends \PHPUnit_Framework_TestCase
{
    
    public function testAddingExistingModule()
    {
        $composite = new Composite;
        $componentFactory = new Factory;
        $composite->addComponent($componentFactory->build('System', 'Linux', ['test']));
        $reflection = $this->setPropertyAccessible($composite, 'modules');
        $this->assertCount(1, $reflection->getValue($composite));
        $this->assertTrue(get_class($reflection->getValue($composite)[0]) == 'Api\Module\Linux\System');
    }

    public function testAddingExistingModuleForWindows()
    {
        $composite = new Composite;
        $componentFactory = new Factory;
        $composite->addComponent($componentFactory->build('System', 'Windows', ['test']));
        $reflection = $this->setPropertyAccessible($composite, 'modules');
        $this->assertCount(1, $reflection->getValue($composite));
        $this->assertTrue(get_class($reflection->getValue($composite)[0]) == 'Api\Module\Windows\System');
    }

    public function setPropertyAccessible(&$object, $propertyName)
    {
        $reflection = new \ReflectionClass($object);
        $reflectionProperty = $reflection->getProperty($propertyName);
        $reflectionProperty->setAccessible(true);
        return $reflectionProperty;
    }
}