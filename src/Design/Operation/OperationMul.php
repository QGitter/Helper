<?php

namespace QGitter\Design\Operation;
/**
 * 工厂子类减法类
 * Class OperationMul
 * @package QGitter\Design\Operation
 */
class OperationMul extends Operation
{
    public function __construct($a, $b)
    {
        parent::__construct($a, $b);
    }

    public function getResult()
    {
        return $this->a - $this->b;
    }
}