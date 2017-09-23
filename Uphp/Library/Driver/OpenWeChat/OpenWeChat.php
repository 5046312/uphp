<?php
namespace Uphp\Driver\OpenWeChat;
use Uphp\Log;

/**
 * OpenWeChat抽象类
 * Class OpenWeChat
 * @package Uphp\Driver\OpenWeChat
 */
abstract class OpenWeChat
{
    public $config;
    public $access_token;

    public function __construct($config, $access_token)
    {
        $this->config = $config;
        $this->access_token = "access_token=".$access_token;
    }

    public function __call($name, $arguments)
    {
        $startTime = microtime(true);
        $res = call_user_func_array([$this, $name], $arguments);
        $className = explode("\\", get_class($this));
        if(isset($res['errcode']) && $res['errcode'] != 0){
            #   微信接口调用失败
            Log::add("OpenWeChat X ".end($className)."/".$name." [".round(microtime(true)-$startTime, 3)."s] ".json_encode($res));
        }else{
            #   成功
            Log::add("OpenWeChat √ ".end($className)."/".$name." [".round(microtime(true)-$startTime, 3)."s] ".json_encode($res));
        }
        return $res;
    }
}