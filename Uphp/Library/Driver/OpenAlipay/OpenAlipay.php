<?php
namespace Uphp\Driver\OpenAlipay;
use Uphp\Log;
/**
 * OpenAlipay抽象类
 * Class OpenAlipay
 * @package Uphp\Driver\OpenAlipay
 */
abstract class OpenAlipay
{
    public $config;
    public $access_token;

    public function __construct($config)
    {

    }

    public function __call($name, $arguments)
    {
        $startTime = microtime(true);
        $res = call_user_func_array([$this, $name], $arguments);
        $className = explode("\\", get_class($this));
        if(isset($res['errcode']) && $res['errcode'] != 0){
            #   微信接口调用失败
            Log::add("OpenAlipay X ".end($className)."/".$name." [".round(microtime(true)-$startTime, 3)."s] ".json_encode($res));
        }else{
            #   成功
            Log::add("OpenAlipay √ ".end($className)."/".$name." [".round(microtime(true)-$startTime, 3)."s] ".json_encode($res));
        }
        return $res;
    }
}