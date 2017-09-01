<?php
namespace uphp;
/**
 * 配置文件类
 * Class Config
 * @package uphp
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
        !is_null(self::$config)?:self::$config = include(U_DIR.'/config/Common.php');
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
        !is_null(self::$config)?:self::$config = include(U_DIR.'/config/Common.php');
        if(strpos($key, ".")){
            $keys = explode(".", $key);
            return @self::$config[$keys[0]][$key[1]];
        }else{
            return @self::$config[$key];
        }
    }
}