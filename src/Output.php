<?php

namespace QGitter;


class Output
{
    use InstanceTrait;

    public $format = 'json';
    public $result = array('code' => 0, 'msg' => '', 'data' => array());

    /**
     * 输出方法
     */
    public function export()
    {
        ob_clean();
        switch ($this->format) {
            case 'xml':
                echo $this->_to_xml($this->result, false);
                break;
            case 'json':
            default:
                echo $this->_to_json($this->result);
                break;
        }
        exit();
    }

    /**
     * json输出
     * @param $result
     * @param bool $setJSONContentType
     * @param string $encoding
     * @return string
     */
    private function _to_json($result, $setJSONContentType = true, $encoding = 'utf-8'): string
    {
        if ($setJSONContentType === true) {
            $this->_setContentType('json', $encoding);
        }
        $convertedArray = $this->convertArrayToUtf8($result);
        $rs = json_encode($convertedArray);
        return $rs;
    }

    /**
     * xml输出
     * @param $result
     * @param bool $setXMLContentType
     * @param string $encoding
     * @return string
     */
    private function _to_xml($result, $setXMLContentType = true, $encoding = 'utf-8'): string
    {
        $xml = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"utf-8\"?><result></result>");
        $this->array_to_xml($result, $xml);
        $str = $xml->asXML();
        if ($setXMLContentType === true) {
            $this->_setContentType('xml', $encoding);
        }
        return $str;
    }

    /**
     * 设置成utf8
     * @param $array
     * @return array
     */
    protected function convertArrayToUtf8($array): array
    {
        $convertedArray = array();
        foreach ($array as $key => $value) {
            if (!mb_check_encoding($key, 'UTF-8')) {
                $key = utf8_encode($key);
            }
            if (is_array($value)) {
                $value = $this->convertArrayToUtf8($value);
            } else {
                if (!mb_check_encoding($value, 'UTF-8')) {
                    $value = utf8_encode($value);
                }
            }
            if ($value === 'null') {
                $value = '';
            }
            if (is_null($value)) {
                $value = '';
            }
            $convertedArray[$key] = $value;
        }
        return $convertedArray;
    }

    /**
     * 数组转xml
     * @param $result
     * @param $xml
     */
    protected function array_to_xml($result, &$xml)
    {
        foreach ($result as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xml->addChild("$key");
                    $this->array_to_xml($value, $subnode);
                } else {
                    $this->array_to_xml($value, $xml);
                }
            } else {
                $xml->addChild("$key", "$value");
            }
        }
    }

    /**
     * 设置content-type
     * @param string $content_type
     * @param string $encoding
     */
    private function _setContentType(string $content_type, string $encoding): void
    {
        switch ($content_type) {
            case 'xml' :
                header("Content-type: text/xml; charset=" . $encoding);
                break;
            case 'json' :
                header("Content-type: application/json; charset=" . $encoding);
                break;
            case 'js' :
                header("Content-type: text/javascript; charset=" . $encoding);
                break;
            case 'html' :
                header("Content-type: text/html; charset=" . $encoding);
                break;
            default :
                header("Content-type: text/plain; charset=" . $encoding);
                break;
        }
    }
}