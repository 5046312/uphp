<?php
namespace Uphp;
/**
 * 核心启动
 * Class Uphp
 * @package Uphp
 */
class Uphp
{
    /**
     * 核心类构造
     * Uphp constructor.
     */
    public function __construct()
    {
        define("APP_START_TIME", microtime());
        #   注册自动加载类
        $this->autoload();
        #   加载系统配置项，用户配置项将按用户全局->模块->控制器依次加载，依次被覆盖
        Config::init(include("Uphp/config.php"));
        #   时区设置
        date_default_timezone_set(Config::get("app.timezone"));
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

    #   启动方法
    public function start(){
        #   开启session
        session_start();
        #   异常处理
        set_exception_handler('Uphp\Error::ExceptionHandler');
        #   错误处理
        set_error_handler('Uphp\Error::ErrorHandler');
        #   TODO:日志类初始化（内部判断开启状态）

        #   路由类初始化
        Route::init();

        $this->callRequestMethod();
    }

    /**
     * 调用请求
     */
    private function callRequestMethod(){
        #   获取应用所在文件路径
        $app_dir = config("dir.application");
        #   判断控制器（异常放入autoload中抛出，省去判断文件步骤）
//        Exception::error(Language::get("CONTROLLER_NOT_EXIST").":"._CONTROLLER_);
//        Exception::error(Language::get("ACTION_NOT_EXIST").":"._ACTION_);
        #   舍去单例，直接实例化
        $controllerString = $app_dir."\\Controller\\"._MODULE_."\\"._CONTROLLER_.'Controller';
        $controller = new $controllerString;
        echo call_user_func_array([$controller, _ACTION_], (array)unserialize(_ARGS_));
        #   TODO:结束日志
        /*if(isset($log_class)){
            $log_args = [
                "Time:" . round((microtime() - APP_START_TIME) * 1000) . "ms".PHP_EOL."::::End::::".PHP_EOL
            ];
            call_user_func_array([$log_class, "save"], $log_args);
        }*/
    }
}