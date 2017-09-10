<?php
namespace Uphp;
/**
 * 路由route类
 * Class Route
 * @package Uphp
 */
class Route
{
    public static $rule;
    /**
     * 路由初始化
     */
    public static function init(){
        #   根据请求类型，加载路由规则
        $rule = include(config("dir.application")."/route.php");
        #   只获取当前请求类型的路由规则
        self::$rule = $rule[$_SERVER['REQUEST_METHOD']];

        #   几种Url形式值得验证（每种情况都分为有index.php和无index.php）
        #   1、已存在路由规则中的、不带$_GET参数  /a/b/c
        #   2、已存在路由规则中的、带$_GET参数   /a/b/c?a=123&m=456
        #   3、有/分割前缀、不存在路由规则中的、不带$_GET参数    /index/b/c
        #   4、有/分割前缀、不存在路由规则中的、带$_GET参数 /index/b/c?a=123&m=456
        #   5、无/分割前缀、带$_GET参数   ?a=123&m=456
        #   6、传参数（以后会该为正则定义可随意排序）

        #   分析当前路由形态
        #   现版本改为多层控制器，去除固定模块
        #   去除/index.php，去除最后可能出现的/
        $uri = trim(str_replace("/index.php", "", $_SERVER['REQUEST_URI']), "/");
        $uriArr = explode("?", $uri);
        p($uriArr);
        die;
        /*if(isset(self::$rule[$uriArr[0]])){
            #   规则存在则使用实例化真实路径
            $route = explode("/", self::$rule[$uriArr[0]]);
        }else{
            #   不存在规则
            #   判断是否存在分割/
            if(strpos($uri, "/")){
                #   存在/
                $route = explode("/", $uriArr[0]);

            }else{
                #   不存在/
                $route = [
                    $_GET['c'] ?: config("app.default_controller"),
                    $_GET['m'] ?: config("app.default_method"),
                ];
            }
        }

        #   Url变量
        define("_CONTROLLER_", $route[1]);
        define("_METHOD_", $route[2]);
        define("_ARGS_", serialize($args));*/
    }
}