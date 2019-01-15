<?php

namespace QGitter;


class ArrayTool
{
    use InstanceTrait;

    /**
     * 递归改变数组的key
     * @param array $input
     * @param int $case
     * @return array
     */
    public function arrayChangeKeyCaseRecursive(array $input = array(), $case = CASE_LOWER): array
    {
        if (!is_array($input)) {
            trigger_error("Invalid input array '{$input}'", E_USER_NOTICE);
            exit;
        }
        if (null === $case) {
            $case = CASE_LOWER;
        }
        if (!in_array($case, array(CASE_UPPER, CASE_LOWER))) {
            trigger_error("Case parameter '{$case}' is invalid.", E_USER_NOTICE);
            exit;
        }
        $input = array_change_key_case($input, $case);
        foreach ($input as $key => $array) {
            if (is_array($array)) {
                $input[$key] = $this->arrayChangeKeyCaseRecursive($array, $case);
            }
        }
        return $input;
    }

    /**
     * 在数组中的某个位置插入数组
     * @param array $array
     * @param int $position
     * @param array $insert_array
     * @return array
     */
    public function arrayInsert(array &$array, int $position, array $insert_array): array
    {
        $part_array = array_splice($array, 0, $position);
        $array = array_merge($part_array, $insert_array, $array);
        return $array;
    }

    /**
     * 将数组分为几个部分
     * @param array $array
     * @param int $p
     * @return array
     */
    public function partitionArray(array $array, int $p): array
    {
        if (!is_array($array) || empty($array)) {
            return [];
        }
        $arr_len = count($array);
        $part_len = floor($arr_len / $p);
        $partrem = $arr_len % $p;
        $partitonArray = array();
        $mark = 0;
        for ($px = 0; $px < $p; $px++) {
            $incr = ($px < $partrem) ? $part_len + 1 : $part_len;
            $partitonArray[$px] = array_slice($array, $mark, $incr);
            $mark += $incr;
        }
        return $partitonArray;
    }

    /**
     * 数组转化为对象
     * @param array $array
     * @return \stdClass
     */
    public function arrayToObject(array $array): \stdClass
    {
        if (gettype($array) != 'array' || !is_array($array)) {
            return new \stdClass();
        }
        foreach ($array as $key => $value) {
            if (gettype($value) == 'array' || gettype($value) == 'object') {
                $array[$key] = (object)$this->arrayToObject($value);
            }
        }
        return (object)$array;
    }

    /**
     * 对象转化为数组
     * @param \stdClass $object
     * @return array
     */
    public function objectToArray(\stdClass $object): array
    {
        $object = (array)$object;
        foreach ($object as $key => $value) {
            if (gettype($value) == 'resource') {
                return [];
            }
            if (gettype($value) == 'objcet' || gettype($value) == 'array') {
                $object[$key] = (array)$this->objectToArray($value);
            }
        }
        return (array)$object;
    }

    /**
     * 返回数组中指定多列
     * @param array $input
     * @param null $columnKey
     * @param null $indexKey
     * @return array
     */
    public function arrayColumns(array $input, $columnKey = null, $indexKey = null): array
    {
        $result = array();
        $tmp = array();
        $keys = isset($columnKey) ? explode(",", $columnKey) : array();
        if ($input) {
            foreach ($input as $key => $value) {
                if ($keys) {
                    foreach ($keys as $k) {
                        $tmp[$k] = $value[$k];
                    }
                } else {
                    $tmp = $value;
                }
                if (isset($indexKey)) {
                    $result[$value[$indexKey]] = $tmp;
                } else {
                    $result[] = $tmp;
                }
            }
        }
        return $result;
    }
}