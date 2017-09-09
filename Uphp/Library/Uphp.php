<?php
namespace Uphp;
/**
 * 核心启动
 * Class Uphp
 * @package Uphp
 */
class Uphp
{
    public $config;

    public function __construct()
    {
        #   加载系统配置项，用户配置项将进行覆盖操作
        $this->config = include("Uphp/config.php");
        #   注册自动加载类
        $this->autoload();
    }


    #   自动加载方法
    private function autoload(){
        spl_autoload_register(function($className){
            # 加载系统类
            if(substr($className, 0, 4) == "Uphp"){
                #   框架目录
                $className = str_replace("\\", "/", $className);
                include_once("Uphp/Library/".substr($className, 5).".php");
            }else{
                include_once($className.'.php');
            }
        });
    }

    #   实例化
    public static function start(){


        #   时区设置
        date_default_timezone_set(config("app.timezone"));
        #   开启session
        session_start();
        #   异常处理
        set_exception_handler('Uphp\Exception::handler');
        #   TODO:日志类初始化（内部判断开启状态）

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
                #   舍去单例
                $controllerString = APP_DIR.'\\'._MODULE_.'\controller\\'._CONTROLLER_.'Controller';
                $controller = new $controllerString;

                #   判断方法
                if(!method_exists($controller, _ACTION_)){
                    Exception::error(Language::get("ACTION_NOT_EXIST").":"._ACTION_);
                }else{
                    echo call_user_func_array([$controller, _ACTION_], (array)unserialize(_ARGS_));
                    #   TODO:结束日志
                    /*if(isset($log_class)){
                        $log_args = [
                            "Time:" . round((microtime()-$startMicroTime) * 1000) . "ms".PHP_EOL."::::End::::".PHP_EOL
                        ];
                        call_user_func_array([$log_class, "save"], $log_args);
                    }*/
                }
            }
        }
    }
}