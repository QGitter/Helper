<?php
/**
 * Created by PhpStorm.
 * User: yangqing
 * Date: 2019/1/15
 * Time: 11:30 AM
 */

use QGitter\ArrayTool;
use PHPUnit\Framework\TestCase;

class ArrayToolTest extends TestCase
{

    public function testArrayChangeKeyCaseRecursive()
    {
        $arr = ArrayTool::getInstance()->arrayChangeKeyCaseRecursive(array("First" => '1', 'TWO' => 2, 'Three' => array('Four' => 3, 'Five' => array('Sxi' => 6, 'sev' => array('egi' => 8)))), 0);
        print_r($arr);
        exit;
    }

    public function testArrayInsert()
    {
        $array = array(1, 2, 3, 4);
        $arr = ArrayTool::getInstance()->arrayInsert($array, 3, array(1, 2));
        print_r($arr);
        exit;
    }

    public function testPartitonArray()
    {
        $citylist = array("Black Canyon City", "Chandler", "Flagstaff", "Gilbert", "Glendale", "Globe", "Mesa", "Miami",
            "Phoenix", "Peoria", "Prescott", "Scottsdale", "Sun City", "Surprise", "Tempe", "Tucson", "Wickenburg");

        $arr = ArrayTool::getInstance()->partitionArray($citylist, 2);
        print_r($arr);
    }

    public function testArrayToObject()
    {
        $obj = ArrayTool::getInstance()->arrayToObject(array('one' => 1, 'two' => 2, 'three' => 3));
        var_dump($obj);
        exit;
    }

    public function testObjectToArray()
    {
        $array = array('one' => 1, 'two' => 2, 'three' => 3, 'four' => array('five' => 1, 'six' => 2));
        $object = ArrayTool::getInstance()->arrayToObject($array);
        $array = ArrayTool::getInstance()->objectToArray($object);
        print_r($array);
    }
}

