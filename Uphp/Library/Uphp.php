<?php
namespace Uphp;
/**
 * 核心启动
 * Class Uphp
 * @package Uphp
 */
class Uphp
{
    public static $instance; // 应用单一入口

    #   隐藏构造
    private function __construct(){}

    #   自动加载方法
    private static function autoload(){
        spl_autoload_register(function($className){
            # 加载系统类
            if(substr($className, 0, 4) == U_DIR){
                include_once(U_DIR."/Library/".substr($className, 5).".php");
            }else{
                include_once($className.'.php');
            }
        });
    }

    #   实例化
    public static function run(){
        error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
        # 引用公共函数
        include(U_DIR.'/Function/Common.php');

        # 公共配置变量
        define("_MODULE_", $_GET['m'] ?: START_MODULE);
        define("_CONTROLLER_", $_GET['c'] ?: START_CONTROLLER);
        define("_ACTION_", $_GET['a'] ?: START_ACTION);

        #   注册自动加载类
        self::autoload();

        #   异常处理
        set_exception_handler("Uphp\Exception::handler");
        Exception::error(Language::get("MODULE_NOT_EXIST"));

        #   判断模块是否存在

        #   判断控制器

        #   判断方法

        #   单例
        if(is_null(self::$instance)){
            $controller = APP_DIR.'\\'._MODULE_.'\controller\\'._CONTROLLER_.'Controller';
            self::$instance = (new $controller)->{_ACTION_}();
        }
        echo self::$instance;
    }
}