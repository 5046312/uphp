<?php
namespace Uphp\Log;
use Uphp\Exception;
use Uphp\Language;

/**
 * 文件日志类
 * 将数组的每个值单独成行，写入日志中
 * Class File
 * @package Uphp\Log
 */
class File
{
    public static $config; // 配置文件
    public static $log; // 日志记录
    /**
     * 初始化，如不配置则使用配置项
     * File constructor.
     * @param null $config
     */
    public static function init($config = NULL){
        self::$config = isset($config) ? $config : config("log.file");
        self::save(date("Y-m-d H:i:s")."##########################################");
    }

    /**
     * 添加日志
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
        #   先判断日志文件夹是否存在
        if(!file_exists(self::$config['dir'])){
            mkdir(self::$config['dir'], 0755, true);
        }
        #   判断今天是否生成过日志文件
        if(!file_exists(self::$config['dir']."/".date(self::$config['date_format']))){
            touch(self::$config['dir']."/".date(self::$config['date_format']).self::$config['suffix']);
        }
        #   文件追加日志
        file_put_contents(self::$config['dir']."/".date(self::$config['date_format']).self::$config['suffix'], self::$log.$addContent.PHP_EOL, FILE_APPEND);
        #   清空变量
        self::$log = NULL;
    }
}