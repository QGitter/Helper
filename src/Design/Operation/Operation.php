<?php

namespace QGitter\Design\Operation;

/**
 * 工厂基类
 * Class Operation
 * @package QGitter\Design\Operation
 */
abstract class Operation
{
    protected $a = 0;
    protected $b = 0;

    protected function __construct($a, $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public abstract function getResult();
}