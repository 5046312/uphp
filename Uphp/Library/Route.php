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
        #   1、已存在路由规则中的、不带$_GET参数  /a /a/b /a/b/c
        #   2、已存在路由规则中的、带$_GET参数   /a/b/c?a=123&m=456
        #   3、有/分割前缀、不存在路由规则中的、不带$_GET参数    /index/b/c
        #   4、有/分割前缀、不存在路由规则中的、带$_GET参数 /index/b/c?a=123&m=456
        #   5、无/分割前缀、带$_GET参数   ?a=123&m=456
        #   6、传参数（以后会该为正则定义可随意排序）

        #   分析当前路由形态
        #   去除/index.php，去除最后可能出现的/
        $uri = trim(str_replace("/index.php", "", $_SERVER['REQUEST_URI']), "/");
        $uriArr = explode("?", $uri);
        #   判断是否定义了路由规则
        if(isset(self::$rule[$uriArr[0]])){
            #   规则存在则使用实例化真实路径
            $route = explode("/", self::$rule[$uriArr[0]]);
        }else{
            #   不存在路由规则
            if(empty($uriArr[0])){
                #   判断是否开启url兼容模式
                if(config('url.both_type')){
                    #   开启兼容模式
                    $route = [
                        $_GET['m'] ?: config("app.default_module"),
                        $_GET['c'] ?: config("app.default_controller"),
                        $_GET['a'] ?: config("app.default_action"),
                    ];
                }else{
                    #   未开启兼容，用$_GET无法定位控制器则调用默认控制器方法
                    $route = [
                        config("app.default_module"),
                        config("app.default_controller"),
                        config("app.default_action"),
                    ];
                }
            }else{
                $route = explode("/", $uriArr[0]);
                if(isset($route[1])){
                    isset($route[2]) ?: $route[2] = config("app.default_action");
                }else{
                    $route[1] = config("app.default_controller");
                    $route[2] = config("app.default_action");
                }
                // todo:从第4位开始则为参数项，取出后进行串行化处理放入常量
            }
            p($route);
            die;

            #   Url变量
            define("_MODULE_", $route[0]);
            define("_CONTROLLER_", $route[1]);
            define("_METHOD_", $route[2]);
            define("_ARGS_", serialize($args));

        }
    }
}