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
                #   框架目录
                $className = str_replace("\\", "/", $className);

                include_once(U_DIR."/Library/".substr($className, 5).".php");
            }else{
                include_once($className.'.php');
            }
        });
    }

    #   实例化
    public static function run(){
        error_reporting(1);
        #   引用公共函数
        include(U_DIR.'/Function/Common.php');
        #   注册自动加载类
        self::autoload();
        #   时区设置
        date_default_timezone_set(config("app.timezone"));
        #   设置session存放路径
        session_save_path(config("session.dir"));
        #   开启session
        session_start();
        #   异常处理
        set_exception_handler('Uphp\Exception::handler');

        #   路由类初始化
        Route::init();

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
                    echo call_user_func_array([self::$instance, _ACTION_], (array)unserialize(_ARGS_));
                }
            }
        }
    }
}