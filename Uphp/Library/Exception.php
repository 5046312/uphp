<?php
namespace Uphp;
/**
 * 异常类
 * Class Exception
 * @package Uphp
 */
class Exception extends \Exception{

    /**
     * 全局异常处理
     * @param $e
     */
    public static function handler($e){
        #   日志

        #   异常报告在开发模式下显示更完全
        if(config("app.debug")){
            $title = $e->message;
            $trace = $e->gettrace();
        }else{
            $title = Language::get('SYSTEM_BUSY');
        }
        include("Uphp/View/exception.php");
    }

    /**
     * 异常抛出
     * @param $info
     * @throws Exception
     */
    public static function error($info){
        throw new self($info);
    }
}