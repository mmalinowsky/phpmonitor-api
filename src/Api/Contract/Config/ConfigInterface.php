<?php
namespace Api\Contract\Config;

interface ConfigInterface
{
    public function loadFromFile($filename);
    public function __get($key);
}
