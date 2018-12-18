<?php
/**
 * Created by PhpStorm.
 * User: yangqing
 * Date: 2018/12/18
 * Time: 9:18 PM
 */

use QGitter\FileSystem;
use PHPUnit\Framework\TestCase;

class FileSystemTest extends TestCase
{

    public function testWriteLog()
    {
        $bool = FileSystem::getInstance()->writeLog('/Users/yangqing/Public/wwwroot/trial/file_system.txt', 'xxxxx');
        var_dump($bool);
    }

    public function testListDir()
    {
        $bool = FileSystem::getInstance()->listDir('/Users/yangqing/Public/wwwroot/trial/');
        echo "<pre>";
        print_r($bool);
        echo "</pre>";
    }

    public function testCreateDir()
    {
        $bool = FileSystem::getInstance()->createDir('/Users/yangqing/Public/wwwroot/trial/file_system/file/system/xxx.txt');
        var_dump($bool);
    }


}
