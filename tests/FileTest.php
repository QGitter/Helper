<?php
/**
 * Created by PhpStorm.
 * User: yangqing
 * Date: 2018/12/18
 * Time: 9:18 PM
 */

use QGitter\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{

    public function testWriteLog()
    {
        $bool = File::getInstance()->writeLog('/Users/yangqing/Public/wwwroot/trial/file_system.txt', 'xxxxx');
        var_dump($bool);
    }

    public function testListDir()
    {
        $bool = File::getInstance()->listDir('/Users/yangqing/Public/wwwroot/trial/');
        echo "<pre>";
        print_r($bool);
        echo "</pre>";
    }

    public function testCreateDir()
    {
        $bool = File::getInstance()->createDir('/Users/yangqing/Public/wwwroot/trial/file_system/file/system/xxx.txt');
        var_dump($bool);
    }

    public function testIsEmpty()
    {
        $bool = File::getInstance()->isEmpty('/Users/yangqing/Public/wwwroot/test/');
        var_dump($bool);
    }


}
