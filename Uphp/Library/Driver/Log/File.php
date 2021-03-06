<?php
namespace Uphp\Driver\Log;
use Uphp\Create;

/**
 * 文件日志类
 * 将数组的每个值单独成行，写入日志中
 * Class File
 * @package Uphp\Driver\Log
 */
class File
{
    public $config; // file类型配置文件
    public $log = ""; // 日志记录
    public $dirExist = false; // 判断目录是否已经存在

    /**
     * 实例化
     * File constructor.
     * @param $config 传入file日志所需配置参数
     */
    public function __construct($config)
    {
        $this->config = $config;
        #   判断日志文件夹是否存在
        if(!file_exists(TRUE_ROOT.$this->config['dir'])){
            mkdir($this->config['dir'], 0755, true);
            Create::createIndexHtml($this->config['dir']);
        }
    }
    /**
     * 追加日志
     * @param $content
     */
    public function add($content){
        #   无需判断是否开启日志，init和save方法才有写入文件操作，执行前已经在Uphp.php中进行处理
        $this->log .= $content.PHP_EOL;
    }

    /**
     * 一次写入到日志文件中
     * 在操作执行结束后或在异常处理时执行，即日志收尾
     */
    public function save(){
        #   文件追加日志
        #   增加文件锁，防止并发
        $log = fopen(TRUE_ROOT.$this->config['dir']."/".date($this->config['date_format']).$this->config['suffix'], "a");
        if(flock($log, LOCK_EX)){
            fwrite($log, $this->log.PHP_EOL);
        }
        flock($log, LOCK_UN);
        fclose($log);
    }
}