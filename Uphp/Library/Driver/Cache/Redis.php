<?php
namespace Uphp\Driver\Cache;
use Uphp\Error;
use Uphp\Language;

/**
 * Redis缓存类
 * Class Redis
 * @package Uphp\Log
 */
class Redis implements Cache
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

    /**
     * redis缓存实例化
     * Redis constructor.
     * @param $config 传入redis配置
     */
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

    /**
     * 获取缓存值
     * @param $key
     * @return bool|string
     */
    public function get($key){
        return $this->link->get($key);
    }

    /**
     * 设置缓存
     * @param $key
     * @param $value
     * @param $timeout 设置有效期
     */
    public function set($key, $value, $timeout){
        #   传入有效期判断
        #   写入成功则返回true
        isset($timeout)
            ? $this->link->setex($key, $timeout, $value) OR Error::exception(Language::get("CACHE_SET_ERROR").":Redis")
            : $this->link->set($key, $value) OR Error::exception(Language::get("CACHE_SET_ERROR").":Redis");
    }

    /**
     * 删除指定键的值
     * 可传数组
     * @param $key
     */
    public function delete($key){
        $this->link->delete($key);
    }

    /**
     * 清空数据库
     */
    public function clear(){
        $this->link->flushDB();
    }
}