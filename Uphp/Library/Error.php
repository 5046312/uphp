<?php
namespace Uphp;
/**
 * 异常、错误类
 * Class Error
 * @package Uphp
 */
class Error extends \Exception{

    /**
     * 错误编号
     * @var array
     */
    public static $errorType = [
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

    /**
     * 异常处理
     * @param $e
     */
    public static function exceptionHandler($e){
        #   清空缓存区
        ob_end_clean();
        #   结束日志
        Log::endLine("Exception # ".$e->getMessage());
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

        #   NOTICE过滤，不在显示
        #   如有新增则以后添加
        switch($no){
            case 8:
                break;
            default:
                $errMsg = self::$errorType[$no]." # {$file}[$line] $str";
                Log::add($errMsg);
        }
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
     * 在PHP5.3、5.4之前没有析构方法的时候使用register_shutdown_function作为析构方法
     */
    public static function fatalHandler(){
        #   判断是否发生错误
        if ($e = error_get_last()) {
            $rootPath = str_replace("/", "\\", TRUE_ROOT);
            $file = str_replace($rootPath, "", $e['file']);
            $errMsg = self::$errorType[$e['type']]." # {$file}[{$e['line']}] {$e['message']}";
            Log::endLine($errMsg);
            switch($e['type']){
                case E_ERROR:
                case E_PARSE:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_USER_ERROR:
                    #   清空缓存区
                    ob_end_clean();
                    #   异常报告在开发模式下显示更完全
                    $error = [];
                    if(config("app.debug")){
                        $error['title'] = $e['message'];
                        $error['file'] = $e['file'];
                        $error['line'] = $e['line'];
                        ob_start();
                        debug_print_backtrace();
                        $error['trace'] = ob_get_clean();
                    }else{
                        $error['title'] = Language::get('SYSTEM_BUSY');
                    }
                    include(TRUE_ROOT.UPHP_DIR."/View/exception.php");
                    break;
            }
        }else{
            #   无错误结束日志
            Log::endLine();
        }
    }
}