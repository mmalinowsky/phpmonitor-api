<?php
namespace Api\Format;

use Api\Contract\Format\FormatInterface;

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
