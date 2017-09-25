<?php
namespace Uphp;

class OpenAlipay
{
    /**
     * 获取支付宝配置信息
     * @var
     */
    private static $OpenAlipayConfig;

    /**
     * 存放driver，减少二次重复实例化
     * @var
     */
    private static $driver;

    /**
     * 多次使用时减少文件读取
     */
    private static function init()
    {
        if(empty(self::$OpenAlipayConfig)){
            self::$OpenAlipayConfig = config('OpenAlipay');
        }
        return self::$OpenAlipayConfig;
    }

    /**
     * 使用魔术方法实例化对应功能Driver
     * @param $driver
     * @param $arguments
     */
    public static function __callStatic($driver, $arguments)
    {
        $driverName = ucfirst(strtolower($driver));
        #   防多次调用多次实例化
        if(isset(self::$driver[$driverName])){
            return self::$driver[$driverName];
        }else{
            #   初次实例化，判断功能对应Driver是否存在
            $driverDir = UPHP_DIR.'\Library\Driver\OpenAlipay\\'.$driverName;
            if(file_exists(TRUE_ROOT.str_replace("\\", "/", $driverDir).".php")){
                $driverClass = UPHP_DIR.'\Driver\OpenAlipay\\'.$driverName;
                self::$driver[$driverName] = new $driverClass(self::init());
                return self::$driver[$driverName];
            }else{
                Error::exception("Driver Not Exist".":".$driverName);
            }
        }
    }
}