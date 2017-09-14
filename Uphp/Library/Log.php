<?php
namespace Uphp;

class Log
{
    public static $config;
    public static $currentType; // 当前日志类型
    public static $currentDriver; // 当前日志驱动
    public static $content; // 临时存放，最后写入文件
    /**
     * 初始化Log类，载入全部日志配置文件
     * @param $type null 传入使用类型，默认使用系统配置中定义的类型
     */
    public static function init($type = NULL){
        empty(self::$config) AND self::$config = config("log");
        #   只有开启状态才会进行实例化等操作
        if(self::isOpen()){
            #   设置日志类型，
            self::$currentType = isset($type) ? strtolower($type) : strtolower(self::$config['type']);
            #   查找日志驱动文件是否存在，验证配置项中的日志类型是否正确
            $driverDir = UPHP_DIR."\\Library\\Driver\\Log\\".ucfirst(strtolower(self::$currentType));
            if(file_exists($driverDir.".php")){
                $driverClass = UPHP_DIR."\\Driver\\Log\\".ucfirst(strtolower(self::$currentType));
                self::$currentDriver = new $driverClass(self::$config[self::$currentType]);
            }else{
                Error::exception(Language::get("LOG_TYPE_ERROR").":".self::$currentType);
            }
        }
    }

    /**
     * 只添加到临时变量中，不写入文件
     * 由save方法一次写入文件中
     * @param $content
     */
    public static function add($content){
        self::$currentDriver->add($content);
    }

    /**
     * 日志功能开关判断
     */
    private static function isOpen(){
        return self::$config['open'];
    }

    /**
     * 单条日志
     * 开始
     * @param null $type 日志类型
     */
    public static function startLine($type = NULL){
        isset(self::$config) OR self::init($type);
        if(self::isOpen()) {
            self::add("::::Start::::");
            self::add(date("Y-m-d H:i:s") . "\t" . $_SERVER['REMOTE_ADDR']);
            self::add($_SERVER['REQUEST_METHOD'] . "\t" . $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * 单条日志
     * 收尾
     * @param null $content 发布一句内容后结束
     */
    public static function endLine($content = NULL){
        if(self::isOpen()){
            if(isset($content)){
                self::add($content);
            }
            $filesNum = count(get_included_files());
            self::add("Time:".round((microtime()-APP_START_TIME) * 1000)."ms"."\t"."File:".$filesNum);
            self::add(":::::End:::::");
            self::$currentDriver->save();
        }
    }

    /**
     * File类型日志特有的分析、统计功能
     */
    public static function analyse(){
        if(self::$currentDriver == "file"){

        }
    }
}