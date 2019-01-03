<?php

namespace QGitter\Design;

/**
 * 单例模式：三私一共，可以保证系统中一个类只有一个实例
 * 应用场景：数据库链接操作，对象操作是唯一操作的时候
 * 1、私有的静态对象变量
 * 2、私有的构造函数
 * 3、私有的克隆函数
 * 4、共有的实例化方法
 */
class Singleton
{
    private static $instances = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function getInstance()
    {
        $class = get_called_class();
        if (empty(self::$instances[$class])) {
            self::$instances[$class] = new $class();
        }
        return self::$instances[$class];
    }
}