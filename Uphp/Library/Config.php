<?php
namespace Uphp;
/**
 * 配置文件类
 * Class Config
 * @package Uphp
 */
class Config
{
    private static $config;

    /**
     * 新增或修改配置项
     * @param $key
     * @param $value
     */
    public static function set($key, $value){
        isset(self::$config) ?: self::$config = include('config.php');
        if(strpos($key, ".")){
            $keys = explode(".", $key);
            self::$config[$keys[0]][$key[1]] = $value;
        }else{
            self::$config[$key] = $value;
        }
    }

    /**
     * 获取配置项的值
     * @param $key
     */
    public static function get($key){
        isset(self::$config) ?: self::$config = include('config.php');
        if(strpos($key, ".")){
            $keys = explode(".", $key);
            return @self::$config[$keys[0]][$keys[1]];
        }else{
            return @self::$config[$key];
        }
    }
}