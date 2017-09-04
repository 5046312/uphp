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
        error_reporting(0);

        #   设置session存放路径
        session_save_path(SESSION_DIR);

        #   开启session
        session_start();

        #   引用公共函数
        include(U_DIR.'/Function/Common.php');

        #   公共配置变量
        define("_MODULE_", $_GET['m'] ?: START_MODULE);
        define("_CONTROLLER_", $_GET['c'] ?: START_CONTROLLER);
        define("_ACTION_", $_GET['a'] ?: START_ACTION);

        #   注册自动加载类
        self::autoload();

        #   异常处理
        set_exception_handler('Uphp\Exception::handler');

        #   判断模块是否存在
        if(!file_exists(APP_DIR."/"._MODULE_)){
            Exception::error(Language::get("MODULE_NOT_EXIST").":"._MODULE_);
        }else{
            #   判断控制器
            if(!file_exists(APP_DIR."/"._MODULE_."/controller/"._CONTROLLER_."Controller.php")){
                Exception::error(Language::get("CONTROLLER_NOT_EXIST").":"._CONTROLLER_);
            }else{
                #   单例
                if(is_null(self::$instance)){
                    $controller = APP_DIR.'\\'._MODULE_.'\controller\\'._CONTROLLER_.'Controller';
                    self::$instance = (new $controller);
                }
                #   判断方法
                if(!method_exists(self::$instance, _ACTION_)){
                    Exception::error(Language::get("ACTION_NOT_EXIST").":"._ACTION_);
                }else{
                    echo self::$instance->{_ACTION_}();
                }
            }
        }
    }
}