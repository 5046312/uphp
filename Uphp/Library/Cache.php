<?php
namespace Uphp;
/**
 * 系统缓存类
 * Class Cache
 * @package Uphp
 */
class Cache
{
    /**
     * 按缓存类型划分的缓存对象
     */
    public static $cache;

    /**
     * 缓存配置项
     * @var
     */
    public static $config;

    /**
     * 当前缓存类型(redis)
     * @var
     */
    public static $currentType;

    /**
     * 载入配置并实例化一个缓存类型的driver
     * 已实例化的则直接使用
     * @param $type
     */
    public static function init($type = NULL){
        if(isset($type)){
            self::$config = config("cache.".$type);
            self::$currentType = $type;
        }else{
            $config = config("cache");
            self::$config = $config[$config['type']];
            self::$currentType = $config['type'];
        }

        #   查找日志驱动文件是否存在，验证配置项中的日志类型是否正确
        $driverDir = UPHP_DIR."\\Library\\Driver\\Cache\\".ucfirst(strtolower(self::$currentType));
        if(file_exists($driverDir.".php")){
            $driverClass = UPHP_DIR."\\Driver\\Cache\\".ucfirst(strtolower(self::$currentType));
            self::$cache = new $driverClass(self::$config);
        }else{
            Error::exception(Language::get("CACHE_TYPE_ERROR").":".self::$currentType);
        }
    }

    public static function get($key){
        empty(self::$config) AND self::init(config("cache.type"));
        return self::$cache->get($key);
    }

    /**
     * 设置缓存
     * @param $key
     * @param $value
     * @param $timeout
     */
    public static function set($key, $value, $timeout = NULL){
        empty(self::$config) AND self::init(config("cache.type"));
        self::$cache->set($key, $value, $timeout);
    }

    /**
     * 删除指定key的键
     * @param $key
     * @return mixed 返回删除key的个数
     */
    public static function delete($key){
        empty(self::$config) AND self::init(config("cache.type"));
        return self::$cache->delete($key);
    }

    /**
     * 清空缓存
     */
    public static function clear(){
        empty(self::$config) AND self::init(config("cache.type"));
        self::$cache->clear();
    }
}