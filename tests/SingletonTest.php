<?php
/**
 * Created by PhpStorm.
 * User: yangqing
 * Date: 2018/12/29
 * Time: 5:26 PM
 */

use QGitter\Design\Singleton;
use PHPUnit\Framework\TestCase;

class SingletonTest extends TestCase
{

    public function testGetInstance()
    {
        Singleton::getInstance();
    }
}
