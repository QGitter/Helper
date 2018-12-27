<?php
/**
 * Created by PhpStorm.
 * User: yangqing
 * Date: 2018/12/26
 * Time: 2:10 PM
 */

use QGitter\Http;
use PHPUnit\Framework\TestCase;

class HttpTest extends TestCase
{

    public function testPost()
    {

    }

    public function testGet()
    {
        $data = Http::getInstance()->get('http://pregameapi.meituyun.com/start/index.json');
        print_r($data);
    }
}
