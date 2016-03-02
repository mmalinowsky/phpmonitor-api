<?php
namespace Api\Format;

class Processor
{
    /**
     * Return format data
     *
     * @param FormatInterface $format
     * @param mixed $data
     */
    public function format(FormatInterface $format, $data)
    {
        return $format->formatData($data);
    }
}
