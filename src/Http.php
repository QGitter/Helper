<?php

namespace QGitter;


class Http
{
    use InstanceTrait;

    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';
    const TIMEOUT = 5;

    private $header = [];
    private $vars = [];
    private $uri = "";
    private $cookies = '';

    /**
     * post请求
     * @param string $url
     * @param array $vars
     * @param array $header
     * @param string $cookies
     * @param array $options
     * @return mixed
     * @throws \Exception
     */
    public function post($url = '', $vars = array(), $header = array(), $cookies = '', $options = array())
    {
        $this->setUrl($url);
        $this->setHeader($header);
        $this->setCookie($cookies);
        $this->setVar($vars);
        return $this->request(self::METHOD_POST, $options);
    }

    /**
     * get请求
     * @param string $url
     * @param array $vars
     * @param array $header
     * @param string $cookies
     * @param array $options
     * @return mixed
     * @throws \Exception
     */
    public function get($url = '', $vars = array(), $header = array(), $cookies = '', $options = array())
    {
        $this->setUrl($url);
        $this->setHeader($header);
        $this->setCookie($cookies);
        $this->setVar($vars);
        return $this->request(self::METHOD_GET, $options);
    }

    /**
     * 通用请求
     * @param string $method
     * @param array $option
     * @return mixed
     * @throws \Exception
     */
    private function request($method = self::METHOD_GET, $option = array())
    {
        if ($this->uri == "") {
            throw  new \Exception(__CLASS__ . "uri is empty");
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::TIMEOUT);
        //设置特殊的属性
        if (!empty($option)) {
            curl_setopt_array($ch, $option);
        }
        //处理get请求参数
        if ($method == self::METHOD_GET && !empty($this->vars)) {
            $url_parse = parse_url($this->uri);
            $sep = isset($url_parse['query']) ? '&' : '?';
            $this->uri .= $sep . http_build_query($this->vars);
        }
        //处理post请求参数
        if ($method == self::METHOD_POST) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->vars);
        }
        //设置cookie信息
        if (!empty($this->cookies)) {
            curl_setopt($ch, CURLOPT_COOKIE, $this->cookies);
        }
        //设置头部信息
        if (empty($this->header)) {
            $this->header = [
                'User - Agent: Mozilla / 4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; InfoPath.1)',
                'Accept-Language: zh-cn',
                'Cache-Control: no-cache',
            ];
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($ch, CURLOPT_URL, $this->uri);
        $data = curl_exec($ch);
        if ($err = curl_error($ch)) {
            curl_close($ch);
            throw new \Exception(__CLASS__ . "error:" . $err);
        }
        curl_close($ch);
        return $data;
    }

    /**
     * http sock通信
     * @param string $method
     * @param array $options
     * @return string
     * @throws \Exception
     */
    private function requestSocket($method = self::METHOD_GET, $options = array())
    {
        if ($this->uri == "") {
            throw  new \Exception(__CLASS__ . "uri is empty");
        }
        $url_parse = parse_url($this->uri);
        //处理get请求参数
        if ($method == self::METHOD_GET && !empty($this->vars)) {
            $sep = isset($url_parse['query']) ? '&' : '?';
            $this->uri .= $sep . http_build_query($this->vars);
        }
        //处理post请求参数
        if ($method == self::METHOD_POST && !empty($this->vars)) {
            $this->setHeader("Content-Type: application/x-www-form-urlencoded\r\n");
            $this->setHeader("Content-Length:" . strlen(http_build_query($this->vars)) . "\r\n");
        }
        //组织http请求头信息
        $host = $url_parse['host'];
        $port = isset($url_parse['port']) && ($url_parse['port'] != "") ? $url_parse['port'] : 80;
        $path = isset($url_parse['path']) && ($url_parse['path'] != "") ? $url_parse['path'] : '/';
        $path .= isset($url_parse['query']) ? "?" . $url_parse['query'] : '';

        array_unshift($this->header, $method . " " . $path . " HTTP/1.1\r\n");
        $this->setHeader("Host: " . $host . "\r\n");
        if ($this->cookies != "") {
            $this->setHeader("Cookie: " . $this->cookies . "\r\n");
        }
        $this->setHeader("Connection: Close\r\n");
        $header = "";
        foreach ($this->header as $value) {
            $header .= $value;
        }
        $header .= "\r\n";
        if ($method == self::METHOD_POST && !empty($this->vars)) {
            $header .= http_build_query($this->vars) . "\r\n";
        }
        $ip = gethostbyname($host);
        if (!($fp = fsockopen($ip, $port, $errno, $errstr, self::TIMEOUT))) {
            throw new \Exception(__CLASS__ . ": Can’t connect $host:$port, errno:$errno,message:$errstr");
        }
        fputs($fp, $header);
        $buf = "";
        while (!feof($fp)) {
            $line = fgets($fp, 1024);
            $buf .= $line;
        }
        fclose($fp);
        return $buf;
    }


    /**
     * 设置头部字段
     * @param $header
     */
    private function setHeader($header)
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

    /**
     * 设置变量
     * @param $vars
     */
    private function setVar($vars)
    {
        if (empty($vars)) {
            return;
        }
        if (is_array($vars)) {
            $this->vars = $vars;
        }
    }

    /**
     * 设置url
     * @param $url
     */
    private function setUrl($url)
    {
        if ($url != "") {
            $this->uri = $url;
        }
    }

    /**
     * 设置cookie
     * @param $cookie
     */
    private function setCookie($cookie)
    {
        if (empty($cookie)) {
            return;
        }
        if (is_array($cookie)) {
            $cookiestr = "";
            while (list($k, $v) = each($cookie)) {
                $cookiestr .= ($cookiestr ? ";" : "");
                $cookiestr .= rawurlencode($k) . " = " . rawurlencode($v);
            }
            $this->cookies = $cookiestr;
        } elseif (is_string($cookie)) {
            $this->cookies = $cookie;
        }
    }


}