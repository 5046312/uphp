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

    }

/*"expire" => "", // 规定 cookie 的有效期
"path" => "", // 规定 cookie 的服务器路径
"domain" => "", // 规定 cookie 的域名
"secure"*/

    public static function set($key, $value, $expire = NULL, $path = NULL, $domain = NULL, $secure = NULL){
        #   载入配置
        isset(self::$config) ?: self::$config = config('cookie');

        #   判断传入参数
        isset($expire) ?: self::$config["expire"] = $expire;
        isset($path) ?: self::$config["expire"] = $expire;
        isset($domain) ?: self::$config["expire"] = $expire;
        isset($secure) ?: self::$config["expire"] = $expire;


        #   数组处理
        if(is_array($value)){
            $value = serialize($value);
        }

    }
}