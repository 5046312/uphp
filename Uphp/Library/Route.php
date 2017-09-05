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
        $rules = include("./route.php");
        self::$rule = $rules[$_SERVER['REQUEST_METHOD']];

        #   几种Url形式值得验证（每种情况都分为有index.php和无index.php）
        #   1、已存在路由规则中的、不带$_GET参数  /a/b/c
        #   2、已存在路由规则中的、带$_GET参数   /a/b/c?a=123&m=456
        #   3、有/分割前缀、不存在路由规则中的、不带$_GET参数    /index/b/c
        #   4、有/分割前缀、不存在路由规则中的、带$_GET参数 /index/b/c?a=123&m=456
        #   5、无/分割前缀、带$_GET参数   ?a=123&m=456

        #   分析当前路由形态


        $uri = trim(str_replace("/index.php", "", $_SERVER['REQUEST_URI']), "/");
        $url = explode("?", $uri);
        if(isset(self::$rule[$url[0]])){
            #   规则存在则使用实例化真实路径
            $route = explode("/", self::$rule[$url[0]]);
        }else{
            #   不存在规则
            #   判断是否存在分割/
            if(strpos($uri, "/")){
                #   存在/
                $route = explode("/", $url[0]);
                #   判断个数，若小于3个则用默认控制器或方法填充
                switch(count($route)){
                    case 2:
                        $route[2] = START_ACTION;
                        break;
                    case 1:
                        $route[1] = START_CONTROLLER;
                        $route[2] = START_ACTION;
                        break;
                }
            }else{
                #   不存在/
                $route = [
                    $_GET['m'] ?: START_MODULE,
                    $_GET['c'] ?: START_CONTROLLER,
                    $_GET['a'] ?: START_ACTION
                ];
            }
        }

        #   公共配置变量
        define("_MODULE_", $route[0]);
        define("_CONTROLLER_", $route[1]);
        define("_ACTION_", $route[2]);
    }
}