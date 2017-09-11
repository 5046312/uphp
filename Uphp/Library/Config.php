<?php
namespace Uphp;
/**
 * 配置文件类
 * Class Config
 * @package Uphp
 */
class Config
{
    /**
     * 全局配置项
     * @var
     */
    public static $config;

    public static function init($config){
        if(empty(self::$config)){
            self::$config = $config;
        }else{
            #   不为空则从后向前进行覆盖
            foreach ($config as $area=>$value){
                foreach ($value as $k=>$v){
                    if(!empty($v)){
                        self::$config[$area][$k] = $v;
                    }
                }
            }
        }
        return self::$config;
    }


    /**
     * 新增或修改配置项
     * @param $key
     * @param $value
     */
    public static function set($key, $value){
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
    public static function get($key = Null){
        if(isset($key)){
            if(strpos($key, ".")){
                $keys = explode(".", $key);
                return self::$config[$keys[0]][$keys[1]];
            }else{
                return self::$config[$key];
            }
        }else{
            return self::$config;
        }
    }
}