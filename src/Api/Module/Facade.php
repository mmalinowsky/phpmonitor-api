<?php
namespace Api\Module;

use Api\Exception\Module as ModuleException;
use Api\Module\Factory;

class Facade
{
    
    /**
     * @var Api\Module\ModuleComposite
     */
    private $moduleComposite;
    /**
     * @var Api\Module\Factory
     */
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

    /**
     * Return modules data
     *
     * @return array $this->ModuleComposite->returnData()
     */
    public function returnModulesData()
    {
        return $this->moduleComposite->returnData();
    }
}
