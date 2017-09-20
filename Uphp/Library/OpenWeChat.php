<?php
namespace Uphp;

class OpenWeChat
{
    /**
     * 获取微信配置信息
     * @var
     */
    private static $OpenWeChatConfig;

    private static function init()
    {
        self::$OpenWeChatConfig = config('OpenWeChat');
        #   获取access_token，使用配置中缓存方式储存
    }

    /**
     * 获取access_token
     * @return mixed
     */
    private static function getAccessToken(){
        if($access_token = Cache::get("ACCESS_TOKEN")){
            return $access_token;
        }else{
            $url = "https://".self::$OpenWeChatConfig['WeChatDomain']."/cgi-bin/token?grant_type=client_credential&appid=".self::$OpenWeChatConfig['appId']."&secret=".self::$OpenWeChatConfig['appSecret'];
            #   尝试次数
            for ($i=0; $i<self::$OpenWeChatConfig['timeout']; $i++){
                $r = json_decode(curlGet($url), true);
                if(!isset($r['errcode']) || $r['errcode'] == 0){
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

    /**
     * 自定义菜单
     */
    public static function menu(){

    }

    /**
     * 消息管理
     */
    public static function message(){

    }

    /**
     * 素材管理
     */
    public static function material(){

    }

    /**
     * 用户管理
     */
    public static function user(){

    }

    /**
     * 账号管理
     */
    public static function account(){

    }

    /**
     * 数据统计
     */
    public static function dataCube(){

    }

    /**
     * 微信卡卷
     */
    public static function card(){

    }

    /**
     * 微信门店
     */
    public static function business(){

    }

    /**
     * 微信小店
     */
    public static function shop(){

    }

    /**
     * 微信设备功能
     */
    public static function device(){

    }

    /**
     * 客服功能
     */
    public static function customService(){

    }

    /**
     * 摇一摇
     */
    public static function shake(){

    }

    /**
     * 微信连wifi
     */
    public static function wifi(){

    }

    /**
     * 扫一扫
     */
    public static function scan(){

    }

    /**
     * 微信发票
     */
    public static function invoice(){

    }
}