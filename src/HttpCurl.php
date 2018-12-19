<?php

namespace QGitter;

class HttpCurl
{
    use InstanceTrait;

    private $header = [];

    public function request()
    {

    }

    /**
     * 设置头部字段
     * @param $header
     */
    public function setHeader($header)
    {
        if (empty($header)) {
            return;
        }
        if (is_array($header)) {
            foreach ($header as $k => $v) {
                $this->header[] = is_numeric($k) ? trim($v) : (trim($k) . ":" . trim($v));
            }
        } elseif (is_string($header)) {
            $this->header[] = $header;
        }
    }

}