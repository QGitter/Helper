<?php
/**
 * Created by PhpStorm.
 * User: yangqing
 * Date: 2018/12/28
 * Time: 2:13 PM
 */

use QGitter\Output;
use PHPUnit\Framework\TestCase;

class OutputTest extends TestCase
{

    public function testExport()
    {
        var_dump(Output::getInstance()->export());
    }
}
