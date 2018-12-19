<?php

namespace QGitter;

class Utils
{
    use InstanceTrait;

    /**
     * 格式化字数
     * @param int $size
     * @param int $dec
     * @return string
     */
    public function byteFormat(int $size, int $dec = 2): string
    {
        $unit = array("B", "KB", "MB", "GB", "TB", "PB");
        $pos = 0;
        while ($size >= 1024) {
            $size /= 1024;
            $pos++;
        }
        return round($size, $dec) . " " . $unit[$pos];
    }

    /**
     * 获取当前页面的url
     * @return string
     */
    public function getCurrentPageUrl(): string
    {
        $url = "http://";
        if (!empty($_SERVER['HTTPS'])) {
            $url = "https://";
        }
        if ($_SERVER['SERVER_PORT'] != 80) {
            $url .= $_SERVER['SERVER_NAME'] . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
        } else {
            $url .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        }
        return $url;
    }

    /**
     * 获取真实的客户端ip地址
     * @return string
     */
    public function getClientIp(): string
    {
        $ip = '';
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], 'unknown')) {
            $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $clientIp = trim(current($ipList));
            if (ip2long($clientIp) !== false) {
                $ip = $clientIp;
            }
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], 'unknown')) {
            $ip = trim($_SERVER['HTTP_CLIENT_IP']);
        } elseif (!empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = trim($_SERVER['REMOTE_ADDR']);
        }
        return $ip;
    }
}