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
            #   加载系统类
            #   命名空间判断
            $namespace = explode("\\", $className, 2);
            $dir = "";
            switch ($namespace[0]){
                case UPHP_DIR:
                    $dir = UPHP_DIR."/Library/".$namespace[1].".php";
                    break;
                default:
                    $dir = $className.'.php';
                    break;
            }
            include($dir);
        });
    }

    #   启动方法
    public function start(){
        #   开启session
        session_start();
        #   异常处理
        set_exception_handler(UPHP_DIR.'\Error::exceptionHandler');
        #   错误处理
        set_error_handler(UPHP_DIR.'\Error::errorHandler');
        #   fatal处理
        register_shutdown_function(UPHP_DIR.'\Error::fatalHandler');


        #   日志类初始化（内部判断开启状态）
        #   日志首行在请求时就写入
        Log::startLine();
        #   路由类初始化
        Route::init();

        $this->callRequestMethod();
    }

    /**
     * 调用请求
     */
    private function callRequestMethod(){
        #   判断控制器（异常放入autoload中抛出，省去判断文件步骤）
        #   舍去单例，直接实例化
        #   优先判断模块是否存在
        if(is_dir(APP_DIR."/Controller/"._MODULE_)){
            $controllerString = APP_DIR."\\Controller\\"._MODULE_."\\"._CONTROLLER_.'Controller';
            #   判断控制器是否存在
            if(file_exists($controllerString.".php")){
                $controller = new $controllerString;
                if(method_exists($controller, _ACTION_)){
                    echo call_user_func_array([$controller, _ACTION_], (array)unserialize(_ARGS_));
                }else{
                    Error::exception(Language::get("ACTION_NOT_EXIST").":"._ACTION_);
                }
            }else{
                Error::exception(Language::get("CONTROLLER_NOT_EXIST").":"._CONTROLLER_);
            }
        }else{
            Error::exception(Language::get("MODULE_NOT_EXIST").":"._MODULE_);
        }

        #   TODO:结束日志

    }
}