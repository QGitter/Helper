<?php

namespace QGitter\Design\Proxy;
/**
 * 代理模式
 * 1、抽象主题角色(Db)
 * 2、真实主题角色(Mysql): mysql库
 * 3、代理主题角色(MysqlProxy)
 * Class MysqlProxy
 * @package QGitter\Design\Proxy
 */
class MysqlProxy implements Db
{
    protected $writer = null;
    protected $reader = null;

    public function __construct()
    {
        $this->reader = new PDO('mysql:host=127.0.0.1;port=3306;dbname=dbname;', 'root', 'password');
        $this->writer = new PDO('mysql:host=127.0.0.2;port=3306;dbname=dbname;', 'root', 'password');
    }

    public function query($sql)
    {
        if (strtolower(substr($sql, 0, 6)) == 'select') {
            return $this->reader->query($sql);
        } else {
            return $this->writer->query($sql);
        }
    }

}