<?php
namespace Uphp;
/**
 * 模板类
 * Class View
 * @package Uphp
 */
class View
{
    public $tplContent; // 模板文件内容
    public $config; // 模板配置
    public $variable; // 变量存储

    public function __construct($file, $data){
        // 指定文件目录
        $this->tplContent = file_get_contents($file);
        // 赋值变量
        $this->variable = $data;
    }

    /**
     * 模板引擎处理后的返回结果
     * @return string
     */
    public function show(){

    }

    private function parseTag(){

    }
}