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
            if ($file == "." || $file == "..") {
                continue;
            }
            $filename = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_link($filename)) {
                continue;
            }
            if (is_file($filename)) {
                $filename_array[] = "文件:" . $filename . PHP_EOL;
            } elseif (is_dir($filename)) {
                $filename_array[] = "目录:" . $filename . PHP_EOL;
                $this->listDir($filename, $filename_array);
            }
        }
        closedir($dir_handler);
        return $filename_array;
    }

    /**
     * 递归删除目录
     * @param $dir
     * @return bool
     */
    public function delDir($dir): bool
    {
        if (!is_dir($dir)) {
            return false;
        }
        $dir_handler = opendir($dir);
        while (($file = readdir($dir_handler)) !== false) {
            if ($file == "." && $file == "..") {
                continue;
            }
            $filename = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_file($filename)) {
                unlink($filename);
            } elseif (is_dir($filename)) {
                $this->delDir($filename);
            }
        }
        closedir($dir_handler);
        rmdir($dir);
        return true;
    }

    /**
     * 统计目录大小
     * @param string $dir
     * @return int
     */
    function dirsize(string $dir): int
    {
        if (!is_dir($dir)) {
            return 0;
        }
        $dirsize = 0;
        $dir_handler = opendir($dir);
        while ($file = readdir($dir_handler)) {
            if ($file == "." && $file == "..") {
                continue;
            }
            $filename = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($file)) {
                $dirsize += $this->dirsize($filename);
            } else {
                $dirsize += filesize($filename);
            }
        }
        closedir($dir_handler);
        return $dirsize;
    }

    /**
     * 返回指定文件和目录的信息
     * @param string $file
     * @return array
     */
    public function listInfo(string $file): array
    {
        if (!file_exists($file)) {
            return [];
        }
        $dir = array();
        $dir['filename'] = basename($file);//返回路径中的文件名部分。
        $dir['pathname'] = realpath($file);//返回绝对路径名。
        $dir['owner'] = fileowner($file);//文件的 user ID （所有者）。
        $dir['perms'] = fileperms($file);//返回文件的 inode 编号。
        $dir['inode'] = fileinode($file);//返回文件的 inode 编号。
        $dir['group'] = filegroup($file);//返回文件的组 ID。
        $dir['path'] = dirname($file);//返回路径中的目录名称部分。
        $dir['atime'] = fileatime($file);//返回文件的上次访问时间。
        $dir['ctime'] = filectime($file);//返回文件的上次改变时间。
        $dir['perms'] = fileperms($file);//返回文件的权限。
        $dir['size'] = filesize($file);//返回文件大小。
        $dir['type'] = filetype($file);//返回文件类型。
        $dir['ext'] = is_file($file) ? pathinfo($file, PATHINFO_EXTENSION) : '';//返回文件后缀名
        $dir['mtime'] = filemtime($file);//返回文件的上次修改时间。
        $dir['isDir'] = is_dir($file);//判断指定的文件名是否是一个目录。
        $dir['isFile'] = is_file($file);//判断指定文件是否为常规的文件。
        $dir['isLink'] = is_link($file);//判断指定的文件是否是连接。
        $dir['isReadable'] = is_readable($file);//判断文件是否可读。
        $dir['isWritable'] = is_writable($file);//判断文件是否可写。
        $dir['isUpload'] = is_uploaded_file($file);//判断文件是否是通过 HTTP POST 上传的。
        return $dir;
    }

}