<?php
namespace Api\Format;

use Api\Exception\Api as ApiException;

class Factory
{
    
    private $types = [
        'json' => 'Api\Format\Json',
        'xml'  => 'Api\Format\Xml'
    ];

    public function createFormat($type)
    {
        if ( ! array_key_exists($type, $this->types)
          || ! class_exists($this->types[$type])
        ) {
            throw new ApiException('Format Type: '.$type.' not found.');
        }
        $className = $this->types[$type];
        return new $className;
    }
}
