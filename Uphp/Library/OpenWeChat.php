<?php
namespace Uphp;

class OpenWeChat extends Controller
{
    /**
     * 获取微信配置信息
     * @var
     */
    private $OpenWeChatConfig;

    public function __construct()
    {
        parent::__construct();
        $this->OpenWeChatConfig = config('OpenWeChat');
        #   获取access_token，使用配置中缓存方式储存

        p($this->getAccessToken());

    }

    private function getAccessToken(){
        if($access_token = Cache::get("ACCESS_TOKEN")){
            return $access_token;
        }else{
            $url = "https://{$this->OpenWeChatConfig['WeChatDomain']}/cgi-bin/token?grant_type=client_credential&appid={$this->OpenWeChatConfig['appId']}&secret={$this->OpenWeChatConfig['appSecret']}";
            #   尝试次数
            for ($i=0; $i<$this->OpenWeChatConfig['timeout']; $i++){
                $r = json_decode(curlGet($url), true);
                if(!isset($r['errcode'])){
                    #   正确获取，缓存预留十分钟
                    Cache::set("ACCESS_TOKEN", $r['access_token'], $r['expires_in'] - 600);
                    Log::add("OpenWeChat # 获取access_token");
                    return $r;
                }
            }
            #   全部失败
            Error::exception("OpenWeChat Access_Token 获取失败");
        }
    }


}