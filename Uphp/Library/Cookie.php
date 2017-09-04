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

    /**
     * 获取Cookie，数组自动转换
     * @param $key
     * @return mixed|null
     */
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

    /**
     * 设置Cookie，数组自动处理
     * @param $key
     * @param $value
     * @param null $expire 有效时间（从当前时间起)
     * @param null $path
     * @param null $domain
     * @param null $secure
     */
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