<?php
namespace Api\Module;

use Api\Exception\Module as ModuleException;
use Api\Module\Factory;

class Facade
{
    
    private $moduleComposite;
    private $moduleFactory;

    public function __construct(Factory $moduleFactory, Composite $moduleComposite)
    {
        $this->moduleFactory = $moduleFactory;
        $this->moduleComposite = $moduleComposite;
    }

    /**
     * Add Module
     * @param string $moduleName
     * @param array  $args
     */
    public function addModule($moduleName, $args = [])
    {
        try {
            $module = $this->moduleFactory->build($moduleName, PHP_OS, $args);
            $this->moduleComposite->addComponent($module);
        } catch (ModuleException $e) {

        }
    }

    public function returnModulesData()
    {
        return $this->moduleComposite->returnData();
    }
}
