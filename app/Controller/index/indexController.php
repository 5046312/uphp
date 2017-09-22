<?php
namespace app\Controller\index;
use app\Model\UserModel;
use Uphp\Cache;
use Uphp\Controller;
use Uphp\OpenWeChat;

class indexController extends Controller
{
    public function index(){
        $subscribe = [
            "MsgType" => "text", // * 消息类型
            "Content" => "怕怕大神大神大声大声道\n啊实打实大师的", // * 发送的文字内容（支持换行）
        ];
        OpenWeChat::Message()->eventReturn("subscribe", $subscribe);
    }
}