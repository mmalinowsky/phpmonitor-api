<?php
namespace Api\Module;

use Api\Module\Facade as ModuleFacade;
use Api\Module\Factory;

class FacadeTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->logger = $this->getMockBuilder('Monolog\Logger')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testAddingExistingModule()
    {
        $moduleFacade = new ModuleFacade(new Factory, new Composite, $this->logger);
        $moduleFacade->addModule('System', ['test']);
    }

    /**
    * @expectedException InvalidArgumentException
    */
    public function testAddingExisitngModuleWithInvalidArguments()
    {
        $moduleFacade = new ModuleFacade(new Factory, new Composite, $this->logger);
        $moduleFacade->addModule('System', []);
    }
}
