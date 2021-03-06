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
        define("APP_START_TIME", microtime(true));
        #   注册自动加载类
        $this->autoload();
        #   加载系统配置项，用户配置项将按用户全局->模块->控制器依次加载，依次被覆盖
        Config::init(include(UPHP_DIR."/config.php"));
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
                    $dir = UPHP_DIR."/Library/".str_replace("\\", "/", $namespace[1]).".php";
                    break;
                default:
                    $dir = str_replace("\\", "/", $className).'.php';
                    break;
            }
            include_once($dir);
        });
        #   引入composer自动加载文件
        if(file_exists("vendor/autoload.php")){
            include("vendor/autoload.php");
        }

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
        #   首次进入应用时，进行应用目录和部分文件创建的初始化操作
        Create::init(APP_DIR);
        #   路由类初始化
        Route::init();
        #   引入用户模块和控制器配置
        Config::userConfigInit();
        #   日志类初始化（内部判断开启状态）
        #   日志首行在请求时就写入
        Log::startLine();
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
            $controllerString = APP_DIR."/Controller/"._MODULE_."/"._CONTROLLER_.'Controller';
            #   判断控制器是否存在
            if(file_exists(TRUE_ROOT.$controllerString.".php")){
                $c = APP_DIR."\Controller\\"._MODULE_."\\"._CONTROLLER_.'Controller';
                $controller = new $c;
                if(method_exists($controller, _ACTION_)){
                    #   引用应用中function
                    if(file_exists(TRUE_ROOT.APP_DIR."/Function/function.php")){
                        include_once(TRUE_ROOT.APP_DIR."/Function/function.php");
                    }
                    echo call_user_func_array([$controller, _ACTION_], (array)unserialize(_ARGS_));
                }else {
                    Error::exception(Language::get("ACTION_NOT_EXIST").":"._ACTION_);
                }
            }else {
                Error::exception(Language::get("CONTROLLER_NOT_EXIST").":"._CONTROLLER_);
            }
        }else {
            Error::exception(Language::get("MODULE_NOT_EXIST").":"._MODULE_);
        }
    }
}