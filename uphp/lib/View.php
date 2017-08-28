<?php
namespace uphp;
/**
 * 模板类
 * Class View
 * @package uphp
 */
class View
{
    public $tplContent; // 模板文件内容
    public $config; // 模板配置

    public function __construct()
    {
        $this->config = "";
    }

    public function loadFile($file){
        $this->tplContent = file_get_contents($file);
    }

    public function tplOut(){

    }
}