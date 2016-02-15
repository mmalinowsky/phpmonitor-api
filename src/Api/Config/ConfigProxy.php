<?php
namespace Api\Config;

class ConfigProxy
{
    private $config = null;
    const FORMATS = [
                        [
                            'extension' => 'json',
                            'configName' => 'Api\Config\ConfigJson'
                        ],
                    ];

    public function __construct($filename)
    {
        $extension = $this->getFileExtension($filename);
        $configName = $this->searchForConfigName($extension);
        $this->config = new $configName;
        $this->config->loadFromFile($filename);
    }

    private function getFileExtension($filename)
    {
        $extension = explode('.', $filename);
        $extension = strtolower(end($extension));
        return $extension;
    }

    private function searchForConfigName($extension)
    {
        foreach (self::FORMATS as $format) {
            if ($format['extension'] == $extension) {
                return $format['configName'];
            }
        }
        throw new \Exception('Config format can\'t be handled');
    }

    public function __get($name)
    {
        return $this->config->$name;
    }

    public function __set($name, $value)
    {
        $this->config->$name = $value;
    }
}
