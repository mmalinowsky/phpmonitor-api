<?php
namespace Api\Module;

interface CompositeInterface
{
    public function addComponent(ModuleInterface $component);
    public function removeComponent();
}
