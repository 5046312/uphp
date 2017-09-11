<?php
namespace Uphp;
/**
 * 异常、错误类
 * Class Error
 * @package Uphp
 */
class Error extends \Exception{

    public static function exceptionHandler($e){
        #   日志

        #   异常报告在开发模式下显示更完全
        $error = [];
        if(config("app.debug")){
            $error['title'] = $e->getMessage();
            $error['trace'] = $e->getTraceAsString();
            $trace = $e->getTrace();
        }else{
            $title = Language::get('SYSTEM_BUSY');
        }

        p($trace);



    }

    public static function errorHandler($no, $str, $file, $line){

    }

    public static function exception($info){
        throw new self($info);
    }

    /**
     * 错误日志管理
     */
    private static function errLog(){

    }

    /**
     * 显示完成trace
     */
    public static function trace($error){
        include("Uphp/View/exception.php");
    }

    /**
     * 只显示系统错误，不显示具体错误原因和trace
     */
    public static function error(){

    }

    /**
     * fatal error 处理
     */
    public static function fatalHandler(){
        #   清空缓存区
        /*ob_clean();
        $e = error_get_last();
        p($e);*/
    }
}