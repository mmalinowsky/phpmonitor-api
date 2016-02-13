<?php
namespace Api\Config;

interface ConfigInterface
{
    public function loadFromFile($filename);
    public function __get($key);
}
