<?php
namespace Api\Format;

/**
 * Class Xml
 */
class Xml implements FormatInterface
{
    
    /**
     * Print data
     * @param mixed $data
     * @return mixed
     */
    public function render($data)
    {
        $xml = new \SimpleXMLElement('<root/>');
        $this->array2XML($xml, $data);
        $ret = $xml->asXml();
        return $ret;
    }
    
    /**
     * Get Header
     * @return string
    */
    public function getHeader()
    {
        return 'Content-Type: application/xml';
    }

    private function array2XML($obj, $array)
    {
        foreach ($array as $key => $value) {
            if (is_numeric($key)) {
                $key = 'item' . $key;
            }

            if (is_array($value)) {
                $node = $obj->addChild($key);
                $this->array2XML($node, $value);
            } else {
                $obj->addChild($key, htmlspecialchars($value));
            }
        }
    }
}
