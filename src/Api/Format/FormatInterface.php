<?php
namespace Api\Format;

/**
 * Class FormatInterface
 */
interface FormatInterface
{
    /**
     * @param mixed $data
     * @return mixed
     */
    public function getHeader();
    public function render($data);
}
