<?php
namespace Uphp;

class OpenWeChat
{
    /**
     * 获取微信配置信息
     * @var
     */
    private static $OpenWeChatConfig;

    /**
     * 预存Driver
     * @var
     */
    private static $driver;

    /**
     * 多次使用时减少文件读取
     */
    private static function init()
    {
        isset(self::$OpenWeChatConfig) OR self::$OpenWeChatConfig = config('OpenWeChat');
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
     * 使用魔术方法实例化对应功能Driver
     * @param $driver
     * @param $arguments
     */
    public static function __callStatic($driver, $arguments)
    {
        #   引入微信配置
        self::init();

        #   防多次调用多次实例化
        if(isset(self::$driver[ucfirst(strtolower($driver))])){
            return self::$driver[ucfirst(strtolower($driver))];
        }else{
            #   初次实例化，判断功能对应Driver是否存在
            $driverDir = UPHP_DIR.'\Library\Driver\OpenWeChat\\'.ucfirst(strtolower($driver));
            if(file_exists($driverDir.".php")){
                $driverClass = UPHP_DIR.'\Driver\OpenWeChat\\'.ucfirst(strtolower($driver));
                $driver = new $driverClass(self::$config[self::$currentType]);
                return $driver;
            }else{
                Error::exception(Language::get("LOG_TYPE_ERROR").":".self::$currentType);
            }
        }
    }
}