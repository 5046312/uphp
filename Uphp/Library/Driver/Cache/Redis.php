<?php
namespace Uphp\Driver\Cache;
use Uphp\Error;
use Uphp\Language;

/**
 * Redis缓存类
 * Class Redis
 * @package Uphp\Log
 */
class Redis
{
    /**
     * 资源
     * @var
     */
    public $link;

    /**
     * config
     * @var
     */
    public $config;

    public function __construct($config)
    {
        if (!extension_loaded('redis')) {
            Error::exception(Language::get("NOT_EXTENSION").":Redis");
        }
        $this->config = $config;
        $this->link = new \Redis();
        $connect = $config['pconnect'] ? "pconnect" : "connect" ;
        $this->link->$connect($config['host'], $config['port'], $config['timeout']);
    }

    public function get($key){
        return $this->link->get($key);
    }

    public function set($key, $value){
        #   写入成功则返回true
        $this->link->set($key, $value) OR Error::exception(Language::get("CACHE_SET_ERROR").":Redis");
    }

    /**
     * 删除指定键的值
     * 可传数组
     * @param $key
     */
    public function delete($key){
        return $this->link->delete($key);
    }

    /**
     * 清空数据库
     */
    public function clear(){
        $this->link->flushDB();
    }
}