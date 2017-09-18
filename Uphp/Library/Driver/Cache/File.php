<?php
namespace Uphp\Driver\Cache;

/**
 * 文件缓存类
 * Class File
 * @package Uphp\Cache
 */
class File implements Cache
{
    public $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function get($key)
    {
        return (string)file_get_contents($this->config['dir']."/".md5($key));
    }

    public function set($key, $value, $timeout = NULL)
    {
        $file = fopen($this->config['dir']."/".md5($key), "w");
        if(flock($file, LOCK_EX)){
            fwrite($file, $value);
        }
        flock($file, LOCK_UN);
        fclose($file);
    }

    public function delete($key)
    {
        unlink($this->config['dir']."/".md5($key));
    }

    public function clear()
    {
        //TODO:清空全部文件缓存
    }
}