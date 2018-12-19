<?php

namespace QGitter;

class File
{
    use InstanceTrait;

    /**
     * 并发加锁写日志
     * @param string $filename
     * @param string $str
     * @return bool
     */
    public function writeLog(string $filename, string $str): bool
    {
        $hander = fopen($filename, 'a');
        if (flock($hander, LOCK_EX)) {
            fwrite($hander, $str . PHP_EOL);
            flock($hander, LOCK_UN);
        } else {
            return false;
        }
        fclose($hander);
        return true;
    }

    /**
     * 递归创建目录
     * @param string $path
     * @param int $mode
     * @return bool
     */
    public function createDir(string $path, int $mode = 0777): bool
    {
        if (is_dir($path)) {
            return true;
        }
        if (!mkdir($path, $mode, true)) {
            return false;
        }
        return true;
    }

    /**
     * 判断该目录是否为空
     * @param string $dir
     * @return bool
     */
    public function isEmpty(string $dir): bool
    {
        if (!is_dir($dir)) {
            return true;
        }
        $dir_handle = opendir($dir);
        while (($file = readdir($dir_handle)) !== false) {
            if ($file != '.' && $file != "..") {
                closedir($dir_handle);
                return false;
            }
        }
        closedir($dir_handle);
        return true;
    }

    /**
     * 递归遍历目录下所有文件
     * @param string $dir
     * @param array $filename_array
     * @return array
     */
    public function listDir(string $dir, array &$filename_array = []): array
    {
        if (!is_dir($dir)) {
            return [];
        }
        $dir_handler = opendir($dir);
        while (($file = readdir($dir_handler)) !== false) {
            if ($file != "." && $file != "..") {
                $filename = $dir . DIRECTORY_SEPARATOR . $file;
                if (is_file($filename)) {
                    $filename_array[] = "文件:" . $filename . PHP_EOL;
                } elseif (is_dir($filename)) {
                    $filename_array[] = "目录:" . $filename . PHP_EOL;
                    $this->listDir($filename, $filename_array);
                }
            }
        }
        closedir($dir_handler);
        return $filename_array;
    }
}