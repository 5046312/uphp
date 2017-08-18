<?php
namespace uphp;

// 控制器类
class Controller
{
    public function __construct()
    {

    }

    // 指定模板名称（默认为对应方法名）
    public function view($tplName){
        echo $tplName;
    }

    // 设置tpl变量
    public function setValue($value){

    }
}