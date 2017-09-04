<?php
namespace Uphp;
/**
 * 多语言支持
 * Class Language
 * @package Uphp
 */
class Language
{
    /**
     * 当前使用的语言
     * 直接把当前语言的所有配置语言获取过来
     * @var
     */
    public static $language;

    /**
     * 选择使用的语言
     * @param $lang
     */
    public static function init($lang){
        $AllLanguage = include_once("./language.php");
        #   判断语言是否存在
        isset($AllLanguage[$lang]) or Exception::error("Language Not Exist");
        self::$language = $AllLanguage[$lang];
    }

    /**
     * 获取当前语言的对应数组值
     * 如果没有调用init，则默认使用配置项中的语言
     * @param $key
     */
    public static function get($key){
        isset(self::$language) ?: self::init(config("APP.LANGUAGE"));
        return self::$language[$key];
    }

    /**
     * 同获取
     * @param $key
     * @param $value
     */
    public static function set($key, $value){
        isset(self::$language) or self::init(config("APP.LANGUAGE"));
        self::$language[$key] = $value;
    }
}