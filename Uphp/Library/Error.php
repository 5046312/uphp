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
        $error = [];
        if(config("app.debug")){
            $error['title'] = $e->message;
            $trace = $e->getTraceAsString();
        }else{
            $title = Language::get('SYSTEM_BUSY');
        }


        $error = array();
        $error['message']   =   $e->getMessage();
        $trace              =   $e->getTrace();
        if('E'==$trace[0]['function']) {
            $error['file']  =   $trace[0]['file'];
            $error['line']  =   $trace[0]['line'];
        }else{
            $error['file']  =   $e->getFile();
            $error['line']  =   $e->getLine();
        }
        $error['trace']     =   $e->getTraceAsString();

        p($error);



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

    /**
     * 显示完成trace
     */
    public static function trace(){

    }

    /**
     * 只显示系统错误，不显示具体错误原因和trace
     */
    public static function error(){

    }
}