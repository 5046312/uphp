<?php
namespace Uphp\Driver\Cache;
use Uphp\Error;
use Uphp\Language;

/**
 * Memcached缓存类
 * Class Memcached
 * @package Uphp\Log
 */
class Memcached implements Cache
{
    public $link;
    public $config;

    public function __construct($config){
        if(!extension_loaded("memcached")){
            Error::error(Language::get("NOT_EXTENSION").":Memcache");
        }
        $this->config = $config;
        $this->link = new \Memcache;
        $this->link->connect($config['host'], $config['port']) OR Error::exception(Language::get("CACHE_LINK_ERROR").":Memcache");
    }

    public function get($key){
        return $this->link->get($key);
    }

    public function set($key, $value, $timeout = 0){
        $this->link->set($key, $value, null, $timeout);
    }

    public function delete($key){
        return $this->link->delete($key);
    }

    public function clear(){
        $this->link->flush();
    }
}