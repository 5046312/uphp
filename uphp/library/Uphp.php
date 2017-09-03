<?php
namespace Uphp;
/**
 * 核心启动
 * Class Uphp
 * @package uphp
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
                include_once(U_DIR."/library/".substr($className, 5).".php");
            }else{
                include_once($className.'.php');
            }
        });
    }

    #   实例化
    public static function getInstance(){
        #   判断模块是否存在

        #   判断控制器

        #   判断方法

        #   注册自动加载类
        self::autoload();
        #   单例
        if(is_null(self::$instance)){
            $controller = APP_DIR.'\\'._MODULE_.'\controller\\'._CONTROLLER_.'Controller';
            self::$instance = (new $controller)->{_ACTION_}();
        }
        echo self::$instance;
    }
}