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
     * Print data
     * @param FormatInterface $format
     */
    public function renderData(FormatInterface $format, $data)
    {
        return $format->render($data);
    }
}
