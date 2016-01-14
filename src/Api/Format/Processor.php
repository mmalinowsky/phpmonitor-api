<?php
namespace Api\Format;

class Processor
{
    /**
     * Set Header
     * @param FormatInterface $format
    */
    public function setHeader(FormatInterface $format)
    {
        header($format->getHeader());
    }

    /**
     * Return format data
     * @param FormatInterface $format
     */
    public function format(FormatInterface $format, $data)
    {
        return $format->formatData($data);
    }
}
