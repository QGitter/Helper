<?php


namespace QGitter\Design\Operation;
/**
 * 工厂逻辑处理类
 * Class OperationFactory
 * @package QGitter\Design\Operation
 */
class OperationFactory
{
    public static function createOperation($operation, $a, $b)
    {
        $oper = null;
        if (empty($operation)) {
            return false;
        }
        switch ($operation) {
            case '+':
                $oper = new OperationAdd($a, $b);
                break;
            case '-':
                $oper = new OperationMul($a, $b);
                break;
        }
        return $oper;
    }
}