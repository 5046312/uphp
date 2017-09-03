<?php
namespace Uphp;
/**
 * 异常类
 * Class Exception
 * @package Uphp
 */
class Exception extends \Exception{

    public static function handler($e){
        if(!APP_DEV){
            $title = Language::get('SYSTEM_BUSY');
        }else{
            $title = $e->message;
        }
        include(U_DIR."/View/exception.php");
    }

    public static function error($info){
        throw new self($info);
    }
}