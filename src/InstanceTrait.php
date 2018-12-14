<?php

namespace QGitter;

trait InstanceTrait
{
    private static $instances;

    private function __construct()
    {

    }

    private function __clone()
    {

    }

    public static function getInstance()
    {
        $className = get_called_class();
        $args = func_get_args();
        $key = md5($className . ':' . serialize($args));
        if (!isset(self::$instances[$key])) {
            self::$instances[$key] = new $className(...$args);
        }
        return self::$instances[$key];
    }
}