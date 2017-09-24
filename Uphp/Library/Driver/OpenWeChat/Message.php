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

    public $ToUserName;
    public $FromUserName;
    public $get; // 缓存接收的信息，不再重复处理
    /**
     * 接收全部类型消息，并返回数组形式
     * {"ToUserName":"gh_e3af9eff6","FromUserName":"oCOse3W_L-M","CreateTime":"1506044669","MsgType":"text","Content":"123","MsgId":"64684120"}
     * @param $type 过滤指定类型的数据 text image voice video shortvideo location link event
     * @return mixed
     */
    protected function getNormal($type = null){

        /**
         * 文字 text
         * <xml>
         * <ToUserName><![CDATA[toUser]]></ToUserName>
         * <FromUserName><![CDATA[fromUser]]></FromUserName>
         * <CreateTime>1348831860</CreateTime>
         * <MsgType><![CDATA[text]]></MsgType> // 类型
         * <Content><![CDATA[this is a test]]></Content>
         * <MsgId>1234567890123456</MsgId>
         * </xml>
         * */

        /**
         * 图片 image
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

        /**
         * 语音 voice Todo: 开启语音识别后，增加了Recongnition字段
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

        /**
         * 视频 video
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

        /**
         * 小视频 shortvideo
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

        /**
         * 地理位置 location
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

        /**
         * 链接 link
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
        #   存为成员，第二次不在进行处理
        if (isset($this->get)){
            if(isset($type)){
                if($this->get['MsgType'] == $type){
                    return $this->get;
                }else{
                    return null;
                }
            }
            return $this->get;
        }else{
            $postStr = file_get_contents("php://input");
            if (!empty($postStr)) {
                $json = json_encode(simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA));
                Log::add("FromWeChat # ".$json);
                $arr = json_decode($json, true);
                $this->get = $arr;
                $this->ToUserName = $arr['FromUserName'];
                $this->FromUserName = $arr['ToUserName'];
                if(isset($type)){
                    if($arr['MsgType'] == $type){
                        return $arr;
                    }else{
                        return null;
                    }
                }
                return $arr;
            }
        }
    }

    protected function getType(){
        $get = $this->getNormal();
        return $get['MsgType'];
    }

    /**
     * 被动回复用户消息
     * @param $info
     */
    protected function returnMsg($info){
        echo $this->sendMsg($info);
        die;
    }

    /**
     * 返回拼装好消息部分的XML
     * @param $info
     * @return string
     */
    private function sendMsg($info){
        switch($info['MsgType']){
            // 文字
            case "text":
                $info = "<xml>
                    <ToUserName><![CDATA[{$this->ToUserName}]]></ToUserName>
                    <FromUserName><![CDATA[{$this->FromUserName}]]></FromUserName>
                    <CreateTime>".time()."</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[{$info['Content']}]]></Content>
                </xml>";
                break;
            // 图片
            case "image":
                $info = "<xml>
                    <ToUserName><![CDATA[{$this->ToUserName}]]></ToUserName>
                    <FromUserName><![CDATA[{$this->FromUserName}]]></FromUserName>
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
                    <ToUserName><![CDATA[{$this->ToUserName}]]></ToUserName>
                    <FromUserName><![CDATA[{$this->FromUserName}]]></FromUserName>
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
                    <ToUserName><![CDATA[{$this->ToUserName}]]></ToUserName>
                    <FromUserName><![CDATA[{$this->FromUserName}]]></FromUserName>
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
                    <ToUserName><![CDATA[{$this->ToUserName}]]></ToUserName>
                    <FromUserName><![CDATA[{$this->FromUserName}]]></FromUserName>
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
                    <ToUserName><![CDATA[{$this->ToUserName}]]></ToUserName>
                    <FromUserName><![CDATA[{$this->FromUserName}]]></FromUserName>
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
        return $info;
    }

    /**
     * 接收事件推送
     * subscribe、unsubscribe、LOCATION、CLICK、scancode_waitmsg
     * @param $type 指定接收的事件类型，如不指定则返回全部事件类型消息
     */
    protected function getEvent($type = null){
        $get = $this->getNormal("event");
        if(isset($type)){
            if($get['Event'] == $type){
                $info['ToUserName'] = $get['FromUserName'];
                $info['FromUserName'] = $get['ToUserName'];
                echo $this->sendMsg($info);
                return $info;
            }else{
                return null;
            }
        } else{
            return $get;
        }

    }
}