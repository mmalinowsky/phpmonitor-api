<?php
namespace Api\Contract\Module;

interface CompositeInterface
{
    public function addComponent(ModuleInterface $component);
    public function removeComponent();
}
