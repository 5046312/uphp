<?php
namespace uphp;
class Config
{
    private static $config;

    /**
     * 初始化配置项
     * @param $config
     */
    public static function init($config){
        self::$config = $config;
    }

    /**
     * 新增或修改配置项
     * @param $key
     * @param $value
     */
    public static function set($key, $value){
        self::$config[$key] = $value;
    }

    /**
     * 获取配置项的值
     * @param $key
     */
    public static function get($key){
        return self::$config[$key];
    }
}