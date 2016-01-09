<?php
namespace Api\Module;

use Api\Module\Facade as ModuleFacade;
use Api\Module\Factory;

class FacadeTest extends \PHPUnit_Framework_TestCase
{
    public function testAddingExistingModule()
    {
        $moduleFacade = new ModuleFacade(new Factory, new Composite);
        $moduleFacade->addModule('System', array('test'));
    }

    /**
    * @expectedException InvalidArgumentException
    */
    public function testAddingExisitngModuleWithInvalidArguments()
    {
        $moduleFacade = new ModuleFacade(new Factory, new Composite);
        $moduleFacade->addModule('System', array());
    }
}
