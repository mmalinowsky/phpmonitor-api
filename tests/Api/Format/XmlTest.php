<?php
namespace Api\Format;

use Api\Format\Xml;

class XmlTest extends \PHPUnit_Framework_TestCase
{

    public function testTwoDimensionalArrayToXml()
    {
        $testArray = [
            'key1' => '1',
            'key2' => '2',
            'Errors' => [
                'test' => 'testvalue'
                ]
        ];
        $xml = '<root><key1>1</key1><key2>2</key2><Errors><test>testvalue</test></Errors></root>';
        $xmlFormat = new Xml;
        $xmlData = $xmlFormat->render($testArray);
        $this->assertContains($xml, $xmlData);
    }
}