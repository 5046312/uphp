<?php
namespace Uphp\Driver\OpenWeChat;
use Uphp\Log;

/**
 * 微信消息处理
 * Class Message
 * @package Uphp\Driver\OpenWeChat
 */
class Message extends OpenWeChat
{

    /**
     * 接收消息，并返回数组形式
     * {"ToUserName":"gh_e3af9eff6","FromUserName":"oCOse3W_L-M","CreateTime":"1506044669","MsgType":"text","Content":"123","MsgId":"64684120"}
     * @param $type 过滤指定类型的数据
     * @return mixed
     */
    protected function get($type = null){
        $postStr = file_get_contents("php://input");
        if (!empty($postStr)) {
            $postObj = json_encode(simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA));
            Log::add("FromWeChat # ".$postObj);
            $arr = json_decode($postObj, true);
            if(isset($type)){
                if($arr['MsgType'] == $type){
                    return $arr;
                }
            }
            return $arr;
        }
    }

    /**
     * 被动回复用户消息
     * @param $text 回复的文字
     * @param $type 接收来的信息类型
     */
    protected function getAndReturn($text, $type = null){
        $get = $this->get($type);
        p($get);
        die;
        // 1 回复文本消息
        // 2 回复图片消息
        // 3 回复语音消息
        // 4 回复视频消息
        // 5 回复音乐消息
        // 6 回复图文消息
        $info = "<xml>
                    <ToUserName><![CDATA[{$get['FromUserName']}]]></ToUserName>
                    <FromUserName><![CDATA[{$get['ToUserName']}]]></FromUserName>
                    <CreateTime>".time()."</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[你好]]></Content>
                </xml>";
        echo $info;
        die;
    }

    /**
     * 接收事件推送
     */
    protected function event(){
        // 关注/取消关注事件
        // 扫描带参数二维码事件
        // 上报地理位置事件
        // 自定义菜单事件

    }




}