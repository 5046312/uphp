<?php
namespace Uphp;
/**
 * Session类
 * Class Session
 * @package Uphp
 */
class Session
{
    public static function get($key){
        if(strpos($key, ".")){
            $keys = explode(".", $key);
            return $_SESSION[$keys[0]][$key[1]];
        }else{
            return $_SESSION[$key];
        }
    }

    /**
     * 设置Session,支持.分割,进行二级设置
     * @param $key
     * @param $value
     */
    public static function set($key, $value){
        if(strpos($key, ".")){
            $keys = explode(".", $key);
            $_SESSION[$keys[0]][$key[1]] = $value;
        }else{
            $_SESSION[$key] = $value;
        }
    }

    /**
     * 查询当前sessionId或查询指定Id的session内容
     * @param $id
     * @return string
     */
    public static function id($id = ""){
        if(empty($id)){
            return session_id();
        }else{
            return session_id($id);
        }
    }
}