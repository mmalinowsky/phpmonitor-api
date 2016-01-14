<?php
namespace Api\Format;

/**
 * Class FormatInterface
 */
interface FormatInterface
{
    /**
     * Return http header
     *
     */
    public function getHeader();
    
    /**
     * Format Data
     *
     * @param mixed $data
     * @return mixed
     */
    public function formatData($data);
}
