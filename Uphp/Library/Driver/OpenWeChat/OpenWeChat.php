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
        return call_user_func_array([$this, $name], $arguments);
    }
}