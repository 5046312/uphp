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
        #   清空缓存区
        ob_end_clean();
        #   结束日志
        Log::endLine("Exception ".$e->getMessage());
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
        $file = str_replace(getcwd(), "", $file);
        $str = str_replace(getcwd(), "", $str);
        $errorType = [
            1=>"Error",
            2=>"Warning",
            4=>"Parsing Error",
            8=>"Notice",
            16=>"Core Error",
            32=>"Core Warning",
            64=>"Complice Error",
            128=>"Compile Warning",
            256=>"User Error",
            512=>"User Warning",
            1024=>"User Notice",
            2048=>"Strict Notice"
        ];
        $errMsg = "{$errorType[$no]} {$file}[$line] $str";
        Log::add($errMsg);
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
     * 显示完整trace
     */
    public static function trace($error){
        include(UPHP_DIR."/View/exception.php");
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
        return;
        #   清空缓存区
        ob_end_clean();

        $e = error_get_last();
        #   结束日志
        Log::endLine($e['title']);

        #   异常报告在开发模式下显示更完全
        $error = [];
        if(config("app.debug")){
            $error['title'] = $e['message'];
            $error['file'] = $e['file'];
            $error['line'] = $e['line'];
            ob_start();
            debug_print_backtrace();
            $error['trace'] = ob_get_clean();
            p($error);
        }else{
            $error['title'] = Language::get('SYSTEM_BUSY');
        }
        $res = include(UPHP_DIR."/View/exception.php");
        p($res);
    }
}