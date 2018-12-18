<?php

namespace QGitter;

class Sort
{
    use InstanceTrait;

    /**
     * 冒泡排序
     * 1、比较相邻的元素。如果第一个比第二个大，就交换它们两个；
     * 2、对每一对相邻元素作同样的工作，从开始第一对到结尾的最后一对，这样在最后的元素应该会是最大的数；
     * 3、针对所有的元素重复以上的步骤，除了最后一个；重复步骤1~3，直到排序完成。
     * @param array $arr
     * @return array
     */
    public function bubbleSort(array $arr): array
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

    /**
     * 插入排序：
     * 1、从第一个元素开始，该元素可以认为已经被排序；
     * 2、取出下一个元素，在已经排序的元素序列中从后向前扫描；
     * 3、如果该元素（已排序）大于新元素，将该元素移到下一位置；
     * 4、重复步骤3，直到找到已排序的元素小于或者等于新元素的位置；
     * 5、将新元素插入到该位置后；重复步骤2~5。
     * @param array $arr
     * @return array
     */
    public function insertSort(array $arr): array
    {
        if (empty($arr)) {
            return [];
        }
        $length = count($arr);
        for ($i = 0; $i < $length; $i++) {
            $preIndex = $i - 1;
            $current = $arr[$i];
            while ($preIndex >= 0 && $arr[$preIndex] > $current) {
                $arr[$preIndex + 1] = $arr[$preIndex];
                $preIndex--;
            }
            $arr[$preIndex + 1] = $current;
        }
        return $arr;
    }

    /**
     * 选择排序：
     * 1、初始状态：无序区为R[1..n]，有序区为空；
     * 2、第i趟排序(i=1,2,3…n-1)开始时，当前有序区和无序区分别为R[1..i-1]和R(i..n）。该趟排序从当前无序区中-选出关键字最小的记录 R[k]，
     * 将它与无序区的第1个记录R交换，使R[1..i]和R[i+1..n)分别变为记录个数增加1个的新有序区和记录个数减少1个的新无序区；
     * 3、n-1趟结束，数组有序化了。
     * @param array $arr
     * @return array
     */
    public function selectSort(array $arr): array
    {
        if (empty($arr)) {
            return [];
        }
        $length = count($arr);
        for ($i = 0; $i < $length - 1; $i++) {
            $minIndex = $i;
            for ($j = $i + 1; $j < $length; $j++) {
                if ($arr[$j] < $arr[$minIndex]) {
                    $minIndex = $j;
                }
            }
            $temp = $arr[$i];
            $arr[$i] = $arr[$minIndex];
            $arr[$minIndex] = $temp;
        }
        return $arr;
    }

    /**
     * 快速排序：
     * 1、从数列中挑出一个元素，称为 “基准”（pivot）；
     * 2、重新排序数列，所有元素比基准值小的摆放在基准前面，所有元素比基准值大的摆在基准的后面（相同的数可以到任一边）。
     * 在这个分区退出之后，该基准就处于数列的中间位置。这个称为分区（partition）操作；
     * 3、递归地（recursive）把小于基准值元素的子数列和大于基准值元素的子数列排序。
     * @param array $arr
     * @return array
     */
    public function quickSort(array $arr): array
    {
        if (empty($arr)) {
            return [];
        }
        $length = count($arr);
        if ($length <= 1) {
            return $arr;
        }
        $leftArray = $rightArray = array();
        $middle = $arr[0];
        for ($i = 1; $i < $length; $i++) {
            if ($arr[$i] < $middle) {
                $leftArray[] = $arr[$i];
            } else {
                $rightArray[] = $arr[$i];
            }
        }
        $leftArray = $this->quickSort($leftArray);
        $rightArray = $this->quickSort($rightArray);
        return array_merge($leftArray, array($middle), $rightArray);
    }

    /**
     * 归并排序
     * 1、申请空间，使其大小为两个已经排序序列之和，该空间用来存放合并后的序列；
     * 2、设定两个指针，最初位置分别为两个已经排序序列的起始位置
     * 3、比较两个指针所指向的元素，选择相对小的元素放入到合并空间，并移动指针到下一位置
     * 4、重复步骤3直到某一指针达到序列尾
     * 5、将另一序列剩下的所有元素直接复制到合并序列尾
     * @param array $arr
     * @return array
     */
    public function mergeSort(array $arr): array
    {
        $length = count($arr);
        if ($length <= 1) {
            return $arr;
        }
        $left = $this->mergeSort(array_slice($arr, 0, floor($length / 2)));
        $right = $this->mergeSort(array_slice($arr, floor($length / 2)));
        $arr = $this->_merge($left, $right);
        return $arr;
    }

    private function _merge(array $left, array $right): array
    {
        $arr = [];
        $i = $j = 0;
        $leftLen = count($left);
        $rightLen = count($right);
        while ($i < $leftLen && $j < $rightLen) {
            if ($left[$i] < $right[$j]) {
                $arr[] = $left[$i];
                $i++;
            } else {
                $arr[] = $right[$j];
                $j++;
            }
        }
        $arr = array_merge($arr, array_slice($left, $i));
        $arr = array_merge($arr, array_slice($right, $j));
        return $arr;
    }


}