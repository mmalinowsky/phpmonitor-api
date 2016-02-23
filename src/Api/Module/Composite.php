<?php
namespace Api\Module;

class Composite implements ModuleInterface, CompositeInterface
{
    /**
     * @var array
     */
    private $modules = [];
    /**
     * @var array
     */
    private $modulesData = [];

    public function __construct()
    {
        $this->modulesData['status'] = 'online';
    }

    /**
     * Add module component
     *
     * @param \Api\Module\ModuleInterface $component
     */
    public function addComponent(ModuleInterface $component)
    {
        $this->modules[] = $component;
    }

    /**
     * Pop module component
     */
    public function removeComponent()
    {
        array_pop($this->modules);
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

    /**
     * Return modules data
     *
     * @return array $this->modulesData
     */
    public function returnData()
    {
        $this->getModulesData();
        return $this->modulesData;
    }
}
