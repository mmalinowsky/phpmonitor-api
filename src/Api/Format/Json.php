<?php
namespace Api\Format;

/**
 * Class Json
 */
class Json implements FormatInterface
{
    
    /**
     * Print data
     * @param mixed $data
     * @return mixed
     */
    public function render($data)
    {
        return json_encode($data);
    }
    
    /**
     * Get Header
     * @return string
    */
    public function getHeader()
    {
        return 'Content-Type: application/json';
    }
}
