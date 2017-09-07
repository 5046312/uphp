<?php
namespace Uphp\Log;

/**
 * 文件日志类
 * 将数组的每个值单独成行，写入日志中
 * Class File
 * @package Uphp\Log
 */
class File
{
    public static $config; // 配置文件
    public static $log = ""; // 日志记录
    public static $dirExist = false; // 判断目录是否已经存在

    /**
     * 初始化
     * File constructor.
     * @param null $content 新日志首行后追加内容
     * @param null $config 如不配置则使用配置项
     */
    public static function init($content = NULL, $config = NULL){
        if(isset($config)){
            self::$config = $config;
        }else{
            $log_config = config('log');
            self::$config = $log_config[$log_config['type']];
        }
        self::$config = isset($config) ? $config : config("log.file");
        #   先判断日志文件夹是否存在
        if(!self::$dirExist && !file_exists(self::$config['dir'])){
            mkdir(self::$config['dir'], 0755, true);
            self::$dirExist = true;
        }
        $txt = "::::Start::::".PHP_EOL.date("Y-m-d H:i:s")."\t".$_SERVER['REQUEST_METHOD']."\t".$_SERVER['REQUEST_URI'];
        empty($content) ?: $txt .= $content;
        self::save($txt);
    }

    /**
     * 追加日志
     * @param $content
     */
    public static function add($content){
        self::$log .= $content.PHP_EOL;
    }

    /**
     * 一次写入到日志文件中
     * @param $addContent
     */
    public static function save($addContent){
        #   file_put_contents函数 如果写入文件不存在则自动创建，省去主动判断、创建文件步骤
        #   文件追加日志
        file_put_contents(self::$config['dir']."/".date(self::$config['date_format']).self::$config['suffix'], self::$log.$addContent.PHP_EOL, FILE_APPEND);
        #   清空变量
        self::$log = "";
    }
}