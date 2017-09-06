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
    public $config; // 配置文件

    /**
     * 初始化，如不配置则使用配置项
     * File constructor.
     * @param null $config
     */
    public function __construct($config = NULL){
        $this->config = isset($config) ? $config : config("log");
        if(strtolower($this->config['type']) != 'file'){
            Exception::error(Language::get("LOG_TYPE_ERROR"));
        }
    }


}