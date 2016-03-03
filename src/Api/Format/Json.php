<?php
namespace Api\Format;

use Api\Contract\Format\FormatInterface;

/**
 * Class Json
 */
class Json implements FormatInterface
{
    
    /**
     * Format data
     * @param mixed $data
     * @return mixed
     */
    public function formatData($data)
    {
        return json_encode($data);
    }
    
    /**
     * Get Header
     * @return string
    */
    public function getHeader()
    {
        return 'application/json';
    }
}
