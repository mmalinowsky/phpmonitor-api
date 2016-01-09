<?php
namespace Api\Module;

use Api\Exception\Api as ApiException;
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
     * @param string $module
     * @param array  $args
     */
    public function addModule($moduleName, $args = array())
    {
        try {
            $module = $this->moduleFactory->build($moduleName, PHP_OS, $args);
            $this->moduleComposite->addComponent($module);
        } catch (ApiException $e) {
            //$this->logger->error($e->getMessage());
        }
    }

    public function returnModulesData()
    {
        return $this->moduleComposite->returnData();
    }
}
