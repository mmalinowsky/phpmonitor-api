<?php
namespace Api\Format;

/**
 * Class FormatInterface
 */
interface FormatInterface
{
    /**
     * Get http header
     */
    public function getHeader();
    /**
     * Render Data
     * @param mixed $data
     * @return mixed
     */
    public function render($data);
}
