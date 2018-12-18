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
        $arr_sort = Sort::getInstance()->bubbleSort($arr);
        print_r($arr_sort);
    }

    public function testInsertSort()
    {
        $arr = array(1, 5, 2, 4, 3);
        $arr_sort = Sort::getInstance()->insertSort($arr);
        print_r($arr_sort);
    }

    public function testSelectSort()
    {
        $arr = array(1, 5, 2, 4, 3);
        $arr_sort = Sort::getInstance()->selectSort($arr);
        print_r($arr_sort);
    }

    public function testQuickSort()
    {
        $arr = array(1, 5, 2, 4, 3);
        $arr_sort = Sort::getInstance()->quickSort($arr);
        print_r($arr_sort);
    }

    public function testMergeSort()
    {
        $arr = array(1, 5, 2, 3, 3, 4, 5, 6, 7, 8, 8, 9, 9);
        $arr_sort = Sort::getInstance()->mergeSort($arr);
        print_r($arr_sort);
    }
}
