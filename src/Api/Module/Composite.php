<?php
namespace Api\Module;

class Composite implements ModuleInterface, CompositeInterface
{
    private $modules = array();
    private $modulesData = array();

    public function __construct()
    {
        $this->modulesData['status'] = 'online';
    }

    public function addComponent(ModuleInterface $component)
    {
        $this->modules[] = $component;
    }

    public function removeComponent()
    {
    }

    /**
     * Fetch data from modules
     */
    private function getModulesData()
    {
        foreach ($this->modules as $module) {
            $recvData = $module->returnData();
            if (is_array($recvData)) {
                $this->modulesData += $recvData;
            }
        }
    }

    public function returnData()
    {
        $this->getModulesData();
        return $this->modulesData;
    }
}
