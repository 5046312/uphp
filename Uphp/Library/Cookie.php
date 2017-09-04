<?php
namespace Uphp;
/**
 * Cookie类
 * Class Cookie
 * @package Uphp
 */
class Cookie
{
    protected static $config;

    public static function get($key){
        if(isset($_COOKIE[$key])){
            $value = $_COOKIE[$key];
            if(substr($value, 0, 10) == "UphpArray_"){
                #   判断数组
                $value = unserialize(substr($value, 10));
            }
            return $value;
        }else{
            return NULL;
        }
    }

    public static function set($key, $value, $expire = NULL, $path = NULL, $domain = NULL, $secure = NULL){
        #   载入配置
        isset(self::$config) ?: self::$config = config('cookie');

        #   判断传入参数
        !isset($expire) ?: self::$config["expire"] = $expire;
        !isset($path) ?: self::$config["path"] = $path;
        !isset($domain) ?: self::$config["domain"] = $domain;
        !isset($secure) ?: self::$config["secure"] = $secure;

        #   数组处理
        $value = is_array($value) ? "UphpArray_".serialize($value) : $value;
        setcookie($key, $value, self::$config['expire'] + time(), self::$config['path'], self::$config['domain'], self::$config['secure']);
        $_COOKIE[$key] = $value;
    }
}