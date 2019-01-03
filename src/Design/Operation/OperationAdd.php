<?php

namespace QGitter\Design\Operation;

/**
 * 工厂类，加法运算子类
 * Class OperationAdd
 * @package QGitter\Design\Operation
 */
class OperationAdd extends Operation
{
    public function __construct($a, $b)
    {
        parent::__construct($a, $b);
    }

    public function getResult()
    {
        return $this->a + $this->b;
    }
}