<?php
/**
 * Created by PhpStorm.
 * User: yangqing
 * Date: 2018/12/19
 * Time: 10:41 AM
 */

use QGitter\Utils;
use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase
{

    public function testByteFormat()
    {
        echo Utils::getInstance()->byteFormat(1024000987654);
    }

    public function testGetRealIp()
    {
        echo Utils::getInstance()->getRealIp();
    }

    public function testTree()
    {
        $arr = array(
            ['id' => '1', 'title' => '科技', 'pid' => 0],
            ['id' => '2', 'title' => '军事', 'pid' => 0],
            ['id' => '3', 'title' => '人工只能', 'pid' => 1],
            ['id' => '4', 'title' => '大中国', 'pid' => 2],
        );
        print_r(Utils::getInstance()->tree($arr));
    }
}
