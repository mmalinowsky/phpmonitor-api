<?php
namespace Api\Format;

use Api\Format\Json;

class JsonTest extends \PHPUnit_Framework_TestCase
{
    public function testRenderIsReturningJson()
    {
        $testArray = ['1','2'];
        $jsonFormat = new Json;
        $jsonData = $jsonFormat->formatData($testArray);
        json_decode($jsonData);
        $this->assertEquals(json_last_error(), JSON_ERROR_NONE);
    }
}
