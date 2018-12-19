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
}
