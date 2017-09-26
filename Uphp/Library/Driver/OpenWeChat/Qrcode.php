<?php
namespace Uphp\Driver\OpenWeChat;

/**
 * 二维码生成
 * 微信文档账号管理中的一项
 * 用户扫描带场景值二维码时，可能推送以下两种事件：
 * 如果用户还未关注公众号，则用户可以关注公众号，关注后微信会将带场景值关注事件推送给开发者。
 * 如果用户已经关注公众号，在用户扫描后会自动进入会话，微信也会将带场景值扫描事件推送给开发者。
 * 获取带参数的二维码的过程包括两步，首先创建二维码ticket，然后凭借ticket到指定URL换取二维码。
 * Class Qrcode
 * @package Uphp\Driver\OpenWeChat
 */
class Qrcode extends OpenWeChat
{
    /**
     * 生成临时ticket 30天(2592000秒) 数量多
     */
    protected function createTemp($str, $timeout = 604800){
        $api = "https://api.weixin.qq.com/cgi-bin/qrcode/create?".$this->access_token;
        $info = [
            "expire_seconds" => $timeout,
            "action_name" => "QR_STR_SCENE",
            "action_info" => [
                "scene" =>
                    [
                        "scene_str" => $str
                    ]
            ]
        ];
        return curl("POST", $api, json_encode($info), true);
    }

    /**
     * 生成永久ticket 10W个
     */
    protected function createForever($str){
        $api = "https://api.weixin.qq.com/cgi-bin/qrcode/create?".$this->access_token;
        $info = [
            "action_name" => "QR_LIMIT_STR_SCENE",
            "action_info" => [
                "scene" =>
                    [
                        "scene_str" => $str
                    ]
            ]
        ];
        return curl("POST", $api, json_encode($info), true);
    }

    /**
     * ticket换取二维码图片
     * @param $ticket
     * @return mixed
     */
    protected function get($ticket){
        $api = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket;
        return curl("GET", $api);
    }
}