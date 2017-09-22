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
     * 接收全部类型消息，并返回数组形式
     * {"ToUserName":"gh_e3af9eff6","FromUserName":"oCOse3W_L-M","CreateTime":"1506044669","MsgType":"text","Content":"123","MsgId":"64684120"}
     * @param $type 过滤指定类型的数据 text image voice video shortvideo location link event
     * @return mixed
     */
    protected function getNormal($type = null){

        // 文字 text
        /**
         * <xml>
         * <ToUserName><![CDATA[toUser]]></ToUserName>
         * <FromUserName><![CDATA[fromUser]]></FromUserName>
         * <CreateTime>1348831860</CreateTime>
         * <MsgType><![CDATA[text]]></MsgType> // 类型
         * <Content><![CDATA[this is a test]]></Content>
         * <MsgId>1234567890123456</MsgId>
         * </xml>
         * */

        // 图片 image
        /**
         * <xml>
         * <ToUserName><![CDATA[toUser]]></ToUserName>
         * <FromUserName><![CDATA[fromUser]]></FromUserName>
         * <CreateTime>1348831860</CreateTime>
         * <MsgType><![CDATA[image]]></MsgType>
         * <PicUrl><![CDATA[this is a url]]></PicUrl>
         * <MediaId><![CDATA[media_id]]></MediaId>
         * <MsgId>1234567890123456</MsgId>
         * </xml>
         * */

        // 语音 voice Todo: 开启语音识别后，增加了Recongnition字段
        /**
         * <xml>
         * <ToUserName><![CDATA[toUser]]></ToUserName>
         * <FromUserName><![CDATA[fromUser]]></FromUserName>
         * <CreateTime>1357290913</CreateTime>
         * <MsgType><![CDATA[voice]]></MsgType>
         * <MediaId><![CDATA[media_id]]></MediaId>
         * <Format><![CDATA[Format]]></Format>
         * <Recognition><![CDATA[腾讯微信团队]]></Recognition>
         * <MsgId>1234567890123456</MsgId>
         * </xml>
         * */

        // 视频 video
        /**
         * <xml>
         * <ToUserName><![CDATA[toUser]]></ToUserName>
         * <FromUserName><![CDATA[fromUser]]></FromUserName>
         * <CreateTime>1357290913</CreateTime>
         * <MsgType><![CDATA[video]]></MsgType>
         * <MediaId><![CDATA[media_id]]></MediaId>
         * <ThumbMediaId><![CDATA[thumb_media_id]]></ThumbMediaId>
         * <MsgId>1234567890123456</MsgId>
         * </xml>
         * */

        // 小视频 shortvideo
        /**
         * <xml>
         * <ToUserName><![CDATA[toUser]]></ToUserName>
         * <FromUserName><![CDATA[fromUser]]></FromUserName>
         * <CreateTime>1357290913</CreateTime>
         * <MsgType><![CDATA[shortvideo]]></MsgType>
         * <MediaId><![CDATA[media_id]]></MediaId>
         * <ThumbMediaId><![CDATA[thumb_media_id]]></ThumbMediaId>
         * <MsgId>1234567890123456</MsgId>
         * </xml>
         * */

        // 地理位置 location
        /**
         * <xml>
         * <ToUserName><![CDATA[toUser]]></ToUserName>
         * <FromUserName><![CDATA[fromUser]]></FromUserName>
         * <CreateTime>1351776360</CreateTime>
         * <MsgType><![CDATA[location]]></MsgType>
         * <Location_X>23.134521</Location_X>
         * <Location_Y>113.358803</Location_Y>
         * <Scale>20</Scale>
         * <Label><![CDATA[位置信息]]></Label>
         * <MsgId>1234567890123456</MsgId>
         * </xml>
         */

        // 链接 link
        /**
         * <xml>
         * <ToUserName><![CDATA[toUser]]></ToUserName>
         * <FromUserName><![CDATA[fromUser]]></FromUserName>
         * <CreateTime>1351776360</CreateTime>
         * <MsgType><![CDATA[link]]></MsgType>
         * <Title><![CDATA[公众平台官网链接]]></Title>
         * <Description><![CDATA[公众平台官网链接]]></Description>
         * <Url><![CDATA[url]]></Url>
         * <MsgId>1234567890123456</MsgId>
         * </xml>
         */
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
     * @param $info
     */
    protected function returnMsg($info){
        switch($info['MsgType']){
            // 文字
            case "text":
                $info = "<xml>
                    <ToUserName><![CDATA[{$info['ToUserName']}]]></ToUserName>
                    <FromUserName><![CDATA[{$info['FromUserName']}]]></FromUserName>
                    <CreateTime>".time()."</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[{$info['Content']}]]></Content>
                </xml>";
                break;
            // 图片
            case "image":
                $info = "<xml>
                    <ToUserName><![CDATA[{$info['ToUserName']}]]></ToUserName>
                    <FromUserName><![CDATA[{$info['FromUserName']}]]></FromUserName>
                    <CreateTime>".time()."</CreateTime>
                    <MsgType><![CDATA[image]]></MsgType>
                    <Image>
                        <MediaId><![CDATA[{$info['MediaId']}]]></MediaId>
                    </Image>
                </xml>";
                break;
            // 语音
            case "voice":
                $info = "<xml>
                    <ToUserName><![CDATA[{$info['ToUserName']}]]></ToUserName>
                    <FromUserName><![CDATA[{$info['FromUserName']}]]></FromUserName>
                    <CreateTime>".time()."</CreateTime>
                    <MsgType><![CDATA[voice]]></MsgType>
                    <Voice>
                        <MediaId><![CDATA[{$info['MediaId']}]]></MediaId>
                    </Voice>
                </xml>";
                break;
            // 视频
            case "video":
                $info = "<xml>
                    <ToUserName><![CDATA[{$info['ToUserName']}]]></ToUserName>
                    <FromUserName><![CDATA[{$info['FromUserName']}]]></FromUserName>
                    <CreateTime>".time()."</CreateTime>
                    <MsgType><![CDATA[video]]></MsgType>
                    <Video>
                        <MediaId><![CDATA[{$info['MediaId']}]]></MediaId>
                        <Title><![CDATA[{$info['Title']}]]></Title>
                        <Description><![CDATA[{$info['Description']}]]></Description>
                    </Video>
                </xml>";
                break;
            // 音乐
            case "music":
                $info = "<xml>
                    <ToUserName><![CDATA[{$info['ToUserName']}]]></ToUserName>
                    <FromUserName><![CDATA[{$info['FromUserName']}]]></FromUserName>
                    <CreateTime>".time()."</CreateTime>
                    <MsgType><![CDATA[music]]></MsgType>
                    <Music>
                        <Title><![CDATA[{$info['Title']}]]></Title>
                        <Description><![CDATA[{$info['Description']}]]></Description>
                        <MusicUrl><![CDATA[{$info['MusicUrl']}]]></MusicUrl>
                        <HQMusicUrl><![CDATA[{$info['HQMusicUrl']}]]></HQMusicUrl>
                        <ThumbMediaId><![CDATA[{$info['ThumbMediaId']}]]></ThumbMediaId>
                    </Music>
                </xml>";
                break;
            // 图文信息
            case "news":
                $info = "<xml>
                    <ToUserName><![CDATA[{$info['ToUserName']}]]></ToUserName>
                    <FromUserName><![CDATA[{$info['FromUserName']}]]></FromUserName>
                    <CreateTime>".time()."</CreateTime>
                    <MsgType><![CDATA[news]]></MsgType>
                    <ArticleCount>{$info['ArticleCount']}</ArticleCount>
                    <Articles>
                        <item>
                        <Title><![CDATA[{$info['ArticleCount']}]]></Title>
                        <Description><![CDATA[{$info['ArticleCount']}]]></Description>
                        <PicUrl><![CDATA[{$info['ArticleCount']}]]></PicUrl>
                        <Url><![CDATA[{$info['ArticleCount']}]]></Url>
                        </item>
                        <item>
                        <Title><![CDATA[{$info['ArticleCount']}]]></Title>
                        <Description><![CDATA[{$info['ArticleCount']}]]></Description>
                        <PicUrl><![CDATA[{$info['ArticleCount']}]]></PicUrl>
                        <Url><![CDATA[{$info['ArticleCount']}]]></Url>
                        </item>
                    </Articles>
                </xml>";
                break;
        }
        // 1 回复文本消息

        echo $info;
        die;

        // 2 回复图片消息
        // 3 回复语音消息
        // 4 回复视频消息
        // 5 回复音乐消息
        // 6 回复图文消息

    }

    /**
     * 接收事件推送
     */
    protected function eventReturn(){
        // 关注/取消关注事件
        $get = $this->get("event");
        switch($get['Event']){
            // 关注公众号
            case "subscribe":
                $info = "<xml>
                            <ToUserName><![CDATA[{$get['FromUserName']}]]></ToUserName>
                            <FromUserName><![CDATA[{$get['ToUserName']}]]></FromUserName>
                            <CreateTime>".time()."</CreateTime>
                            <MsgType><![CDATA[text]]></MsgType>
                            <Content><![CDATA[欢迎关注。。]]></Content>
                        </xml>";
                break;

            // 取消关注
            case "unsubscribe":
                break;

            // 发送地理位置
            case "LOCATION":
                $info = "<xml>
                            <ToUserName><![CDATA[{$get['FromUserName']}]]></ToUserName>
                            <FromUserName><![CDATA[{$get['ToUserName']}]]></FromUserName>
                            <CreateTime>".time()."</CreateTime>
                            <MsgType><![CDATA[text]]></MsgType>
                            <Content><![CDATA[已经锁定了你的位置]]></Content>
                        </xml>";
                break;

            // 点击自定义菜单
            case "CLICK":
                break;

            // 扫描二维码带提示
            case "scancode_waitmsg":
                break;
        }
        echo $info;
        die;
    }




}