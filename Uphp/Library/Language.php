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
     * 当前默认语言包
     * @var
     */
    public static $current;

    /**
     * 语言初始化
     */
    public static function init(){
        if(empty(self::$language)){
            #   先加载框架默认语言包
            self::$language = include(UPHP_DIR."/language.php");
            #   后加载应用默认语言包
            #   合并语言包，从后向前进行覆盖
            if(file_exists(APP_DIR."/Language/language.php")){
                $appLanguage = include(APP_DIR."/Language/language.php");
                foreach ($appLanguage as $lang=>$value){
                    foreach ($value as $k=>$v){
                        if(!empty($v)){
                            self::$language[$lang][$k] = $v;
                        }
                    }
                }
            }
        }
        return self::$language;
    }

    /**
     * 加载用户自定义语言包
     * @param $fileName 语言包文件名
     * @return array
     */
    public static function load($fileName){
        if(file_exists(APP_DIR."/Language/{$fileName}.php")){
            #   引入自定义语言包不需要再次进行覆盖
            $load = include(APP_DIR."/Language/{$fileName}.php");
            self::$language = array_merge(self::init(), $load);
        }else{
            #   自定义语言包不存在
        }
        return self::$language;
    }

    /**
     * 获取当前语言的对应数组值
     * 如果没有调用init，则默认使用配置项中的语言
     * @param $key
     * @param $lang 选择使用的语言包，默认使用系统配置中的默认语言包
     */
    public static function get($key, $lang = NULL){
        isset($lang) ?: $lang = config("app.language");
        return self::init()[$lang][$key];
    }

    /**
     * 同获取
     * @param $key
     * @param $value
     * @param $lang
     */
    public static function set($key, $value, $lang = NULL){
        isset($lang) ?: $lang = config("app.language");
        self::init()[$lang][$key] = $value;
    }
}