<?php
namespace Uphp;

class Log
{
    public function test(){
        $log_config = config('log');
        if($log_config['open']){
            $startMicroTime = microtime();
            switch(strtolower($log_config['type'])){
                case "file":
                    $log_class = U_DIR."\\Log\\FILE";
                    $log_args =  [NULL, $log_config['file']];
                    break;
                default:
                    Exception::error(Language::get("LOG_TYPE_ERROR"));
            }
            call_user_func_array([$log_class, "init"], $log_args);
        }
    }

    public static $config;
    public static $currentType; // 当前日志类型
    public static $currentDriver; // 当前日志驱动
    public static $content; // 临时存放，最后写入文件
    /**
     * 初始化Log类，载入全部日志配置文件
     */
    public static function init(){
        empty(self::$config) AND self::$config = config("log");
        if(self::isOpen()){
            self::$currentType = self::$config['type'];
            #   查找日志驱动文件是否存在，验证配置项中的日志类型是否正确
            $driverDir = UPHP_DIR."\\Library\\Driver\\Log\\".ucfirst(self::$currentType);
            if(file_exists($driverDir.".php")){
                self::$currentDriver = new $driverDir;
            }else{
                Error::exception(Language::get("LOG_TYPE_ERROR"));
            }
        }
    }

    /**
     * 只添加到临时变量中，不写入文件
     * 由save方法一次写入文件中
     * @param $content
     */
    public static function add($content){

    }

    /**
     * 日志结尾保存
     * 一次将临时变量存放的内容写入文件
     * @param null $content
     */
    public static function save($content = NULL){

    }

    /**
     * 日志功能开关判断
     */
    private static function isOpen(){
        return self::$config['open'];
//        self::$config['open'] == true ? (return 123) : return 132312231 ;
    }
}