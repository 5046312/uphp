<?php
namespace Uphp;
/**
 * 异常、错误类
 * Class Error
 * @package Uphp
 */
class Error extends \Exception{

    public static function ExceptionHandler($e){
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

    public static function ErrorHandler($no, $str, $file, $line){

    }

    public static function exception($info){
        throw new self($info);
    }

    /**
     * 错误日志管理
     */
    private static function errLog(){

    }
}