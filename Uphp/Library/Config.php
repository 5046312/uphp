<?php
namespace Uphp;
/**
 * 配置文件类
 * Class Config
 * @package Uphp
 */
class Config
{
    /**
     * 新增或修改配置项
     * @param $key
     * @param $value
     */
    public static function set($key, $value){
        isset(Uphp::$instance['config']) ?: Uphp::$instance['config'] = include('config.php');
        if(strpos($key, ".")){
            $keys = explode(".", $key);
            Uphp::$instance['config'][$keys[0]][$key[1]] = $value;
        }else{
            Uphp::$instance['config'][$key] = $value;
        }
    }

    /**
     * 获取配置项的值
     * @param $key
     */
    public static function get($key){
        isset(Uphp::$instance['config']) ?: Uphp::$instance['config'] = include('config.php');
        if(strpos($key, ".")){
            $keys = explode(".", $key);
            return Uphp::$instance['config'][$keys[0]][$keys[1]];
        }else{
            return Uphp::$instance['config'][$key];
        }
    }
}