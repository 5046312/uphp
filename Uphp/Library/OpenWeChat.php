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
        if(empty(self::$OpenWeChatConfig)){
            self::$OpenWeChatConfig = config('OpenWeChat');
            self::$OpenWeChatConfig['url'] = "https://".self::$OpenWeChatConfig['WeChatDomain']."/cgi-bin/";
        }
        return self::$OpenWeChatConfig;
    }

    /**
     * 获取access_token
     * @return mixed
     */
    private static function getAccessToken(){
        if($access_token = Cache::get("ACCESS_TOKEN")){
            return $access_token;
        }else{
            $url = self::$OpenWeChatConfig['url']."token?grant_type=client_credential&appid=".self::$OpenWeChatConfig['appId']."&secret=".self::$OpenWeChatConfig['appSecret'];
            #   尝试次数
            for ($i=0; $i<self::$OpenWeChatConfig['timeout']; $i++){
                $r = json_decode(curl("GET", $url), true);
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
        self::first();
        $driverName = ucfirst(strtolower($driver));
        #   防多次调用多次实例化
        if(isset(self::$driver[$driverName])){
            return self::$driver[$driverName];
        }else{
            #   初次实例化，判断功能对应Driver是否存在
            $driverDir = UPHP_DIR.'\Library\Driver\OpenWeChat\\'.$driverName;
            if(file_exists(TRUE_ROOT.str_replace("\\", "/", $driverDir).".php")){
                $driverClass = UPHP_DIR.'\Driver\OpenWeChat\\'.$driverName;
                $driver = new $driverClass(self::init(), self::getAccessToken());
                return $driver;
            }else{
                Error::exception("OpenWeChat Driver Not Exist:".$driverName);
            }
        }
    }

    /**
     * 接口配置时使用
     */
    private static function first(){
        #   首次认证，有四个参数，signature、nonce、timestamp、echostr
        if($_GET['echostr']){
            //形成数组，然后按字典序排序
            $array = [$_GET['nonce'], $_GET['timestamp'], self::init()['token']];
            sort($array);
            //拼接成字符串,sha1加密 ，然后与signature进行校验
            if(sha1(implode($array)) == $_GET['signature']){
                echo $_GET['echostr'];
                die;
            }
        }
    }
}