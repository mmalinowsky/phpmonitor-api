<?php
namespace Api\Config;

class ConfigProxy
{
    private $config = null;
    const FORMATS = [
                        ['extension' => 'json', 'name' => 'Api\Config\ConfigJson'],
                    ];

    public function __construct($filename)
    {
        $extension = explode('.', $filename);
        $configName = $this->search(end($extension));
        $this->config = new $configName;
        
        $this->config->loadFromFile($filename);
    }

    private function search($extension)
    {
        foreach(self::FORMATS as $format) {
            if($format['extension'] == $extension)
                return $format['name'];
        }
        throw new \Exception ('Config format can\'t be handled');
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
