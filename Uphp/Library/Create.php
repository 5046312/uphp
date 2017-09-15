<?php
namespace Uphp;
/**
 * 首次访问构建目录结构
 * Class Create
 * @package Uphp
 */
class Create
{
    public static function init($app){
        #   判断应用目录是否已经存在，不存在则进行目录创建流程
        if(!is_dir(APP_DIR)){
            self::createDir();
        }
    }

    private static function createDir(){
        #   创建应用目录
        mkdir(APP_DIR, 0777);
        #   待创建目录
        $dir = [
            ""
        ];
    }

    /**
     * 文件夹目录下创建Index.html
     */
    private static function createIndexHtml(){

    }
}