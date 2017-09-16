<?php
namespace Uphp;
/**
 * 首次访问构建目录结构
 * 模块、控制器、方法默认均为index
 * Class Create
 * @package Uphp
 */
class Create
{
    /**
     * 保存待创建应用目录名
     * @var
     */
    public static $appDir;
    /**
     * 待生成文件夹
     * @var array
     */
    public static $dirs = [
        "/Config",
        "/Controller",
        "/Controller/index", // 此处可以递归生成，但是需要分别创建index.html
        "/Language",
        "/Library",
        "/Model",
        "/View",
    ];

    /**
     * 判断当前入口设置的应用路径是否存在
     * 不存在则进行初始化创建
     * @param $app
     */
    public static function init($app){
        #   判断应用目录是否已经存在，不存在则进行目录创建流程
        if(!is_dir($app)){
            self::$appDir = $app;
            self::createDir();
            self::createFile();
        }
    }

    /**
     * 目录结构创建
     */
    private static function createDir(){
        #   创建应用目录
        mkdir(self::$appDir, 0777);
        #   待创建目录
        foreach (self::$dirs as $k=>$v){
            mkdir(self::$appDir.$v, 0777);
            self::createIndexHtml(self::$appDir.$v);
        }
    }

    /**
     * 文件创建
     */
    private static function createFile(){
        $files = [
            [
                "/route.php",
                "<?php\nreturn [\n\t'GET' => [],\n\t'POST' => []\n];"
            ],
            [
                "/Language/language.php",
                "<?php\nreturn [\n 'ch' => [],'en' => [] ];"
            ],
            [
                "/Config/config.php",
                "<?php\nreturn [\n\n];"
            ],
            [
                "/Controller/index/indexController.php",
                "<?php\nnamespace ".self::$appDir."\Controller\index;\nuse Uphp\Controller;\nclass indexController extends Controller\n{\n\tpublic function index(){\n\t\treturn \"create success\";\n\t}\n}"
            ]
        ];

        #   待创建文件
        foreach ($files as $k=>$v){
            file_put_contents(self::$appDir.$v[0], $v[1]);
        }
    }

    /**
     * 文件夹目录下创建Index.html
     */
    private static function createIndexHtml($dir){
        touch($dir."/index.html");
    }
}