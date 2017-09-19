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
        #   判断缓存文件夹
        if(!is_dir($this->config['dir'])){
            mkdir($this->config['dir'], 0777);
        }
    }

    public function get($key)
    {
        if(!file_exists($this->config['dir']."/".md5($key))){
            return NULL;
        }
        $data = json_decode(file_get_contents($this->config['dir']."/".md5($key)), true);
        if($data['timeout'] < time()){
            #   过期
            unlink($this->config['dir']."/".md5($key));
            return NULL;
        }else{
            return $data['data'];
        }
    }

    public function set($key, $value, $timeout = NULL)
    {
        $file = fopen($this->config['dir']."/".md5($key), "w");
        if(flock($file, LOCK_EX)){
            $data = [
                "timeout" => isset($timeout) ? ((int)$timeout) + time() : 0,
                "data" => $value
            ];
            fwrite($file, json_encode($data));
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
        #   清空全部文件缓存
        #   先判断文件夹是否存在
        if(file_exists($this->config['dir'])){
            $dir = opendir($this->config['dir']);
            while(false != ($f = readdir($dir))){
                if($f == "." || $f == ".."){
                    continue;
                }
                unlink($this->config['dir']."/".$f);
            }
            return true;
        }else{
            #   缓存文件夹不存在
            return true;
        }
    }
}