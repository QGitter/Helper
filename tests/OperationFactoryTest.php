<?php
/**
 * Created by PhpStorm.
 * User: yangqing
 * Date: 2019/1/3
 * Time: 5:27 PM
 */

use QGitter\Design\Operation\OperationFactory;
use PHPUnit\Framework\TestCase;

class OperationFactoryTest extends TestCase
{

    public function testCreateOperation()
    {
        $oper = OperationFactory::createOperation("+", 5, 6);
        echo $oper->getResult();
        $oper = OperationFactory::createOperation("-", 5, 6);
        echo $oper->getResult();
    }
}
