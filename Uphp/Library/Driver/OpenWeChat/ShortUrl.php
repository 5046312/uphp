<?php
namespace Uphp\Driver\OpenWeChat;

/**
 * 生成短连接
 * Class ShortUrl
 * @package Uphp\Driver\OpenWeChat
 */
class ShortUrl extends OpenWeChat
{
    /**
     * 生成短连接
     * @param $url
     * @return mixed
     */
    public function create($url){
        $api = "https://api.weixin.qq.com/cgi-bin/shorturl?".$url;
        $info = [
            "action" => "long2short",
            "long_url" => $url
        ];
        return curl("POST", $api, json_encode($info), true);
    }
}