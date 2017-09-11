<?php
namespace Uphp;
/**
 * 异常、错误类
 * Class Error
 * @package Uphp
 */
class Error extends \Exception{

    /**
     * 异常处理
     * @param $e
     */
    public static function exceptionHandler($e){
        #   日志

        #   异常报告在开发模式下显示更完全
        $error = [];
        if(config("app.debug")){
            $error['title'] = $e->getMessage();
            $error['trace'] = nl2br($e->getTraceAsString());
            $trace = $e->getTrace();
            $error['file'] = $trace[0]['file'];
            $error['line'] = $trace[0]['line'];
            self::trace($error);
        }else{
            $error['title'] = Language::get('SYSTEM_BUSY');
            self::error($error);
        }
    }

    /**
     * 错误处理
     * @param $no
     * @param $str
     * @param $file
     * @param $line
     */
    public static function errorHandler($no, $str, $file, $line){

    }

    /**
     * 抛出异常
     * @param $info
     * @throws Error
     */
    public static function exception($info){
        throw new self($info);
    }

    /**
     * 错误日志管理
     */
    private static function errLog(){

    }

    /**
     * 显示完整trace
     */
    public static function trace($error){
        include("Uphp/View/exception.php");
    }

    /**
     * 只显示系统错误，不显示具体错误原因和trace
     */
    public static function error($error){

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