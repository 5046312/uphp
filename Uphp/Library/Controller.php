<?php
namespace Uphp;

/**
 * 控制器基类
 * Class Controller
 * @package Uphp
 */
class Controller
{
    public function __construct()
    {

    }

    public function redirect($url, $param, $refresh, $view){
        jump(url($url, $param), $refresh, $view);
    }

    public function view($tpl){

    }

    /**
     * 转换数据格式输出
     * @param $data
     * @param string $type 支持XML JSON
     * @param int $option
     */
    public function encode($data, $type = "JSON", $option = 0){
        switch(strtoupper($type)){
            case "JSON":
                header("Content-type:application/json; charset=utf-8");
                die(json_encode($data, $option));
            case "XML":
                header("Content-type:text/xml; charset=utf-8");
                die(xmlEncode($data));
        }
    }
}