<?php
/**
 * Created by PhpStorm.
 * User: yangqing
 * Date: 2018/12/14
 * Time: 11:08 AM
 */


use QGitter\Sort;
use PHPUnit\Framework\TestCase;

class SortTest extends TestCase
{

    public function testBubbleSort()
    {
        $arr = array(1, 5, 2, 4, 3);
        $arr_sort = Sort::getInstance()->BubbleSort($arr);
        print_r($arr_sort);
    }
}
