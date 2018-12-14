<?php

namespace QGitter;

class Sort
{
    use InstanceTrait;

    public function BubbleSort(array $arr): array
    {
        if (empty($arr)) {
            return [];
        }
        $length = count($arr);
        for ($i = 0; $i < $length; $i++) {
            for ($j = 0; $j < $length - 1 - $i; $j++) {
                if ($arr[$j] > $arr[$j + 1]) {
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $temp;
                }
            }
        }
        return $arr;
    }
}