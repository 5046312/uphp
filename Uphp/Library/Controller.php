<?php
namespace Uphp;

/**
 * 控制器基类
 * Class Controller
 * @package Uphp
 */
class Controller
{
    public $viewVariable = []; // 模板变量
    public $logType; // 日志类型

    public function __construct()
    {
        #   日志
        $log_config = config('log');
        if($log_config['open']){
            switch(strtolower($log_config['type'])){
                case "file":
                    $this->logType = "Uphp\\Log\\FILE";
                    call_user_func([$this->logType, "init"]);
                    break;
            }
        }
    }

    /**
     * $this->redirect("index/login", ["a" => "123", "b" => "456"])
     * @param $url
     * @param $param
     * @param $refresh
     * @param $view
     */
    public function redirect($url, $param, $refresh, $view){
        jump(url($url, $param), $refresh, $view);
    }

    /**
     * 绑定模板变量
     * @param $key
     * @param $value
     */
    public function fetch($key, $value){
        if(is_array($key)){
            foreach($key as $k=>$v){
                $this->viewVariable[$k] = $v;
            }
        }else{
            $this->viewVariable[$key] = $value;
        }
    }

    /**
     * 输出模板
     * @param $tpl 指定输出模板(仅限当前模块)
     * @param array $data 指定变量赋值
     */
    public function view($tpl, $data){
        # 附带变量渲染模板
        if(!empty($data)){
            foreach($data as $k=>$v){
                $this->viewVariable[$k] = $v;
            }
        }
        # 指定输出模板
        if(!empty($tpl)){
            # $tpl "index" or "hello/asd"
            if(strpos($tpl, "/")){
                $tpl = explode("/", $tpl);
                $tplFile = "./".APP_DIR."/".$GLOBALS['Uphp']['urlInfo']['m']."/View/".$tpl[0]."/".$tpl[1].Config::get("view_suffix");
            }else{
                $tplFile = "./".APP_DIR."/".$GLOBALS['Uphp']['urlInfo']['m']."/View/".$GLOBALS['Uphp']['urlInfo']['c']."/".$tpl.Config::get("view_suffix");
            }
        }else{
            # empty to find same action template
            $tplFile = "./".APP_DIR."/".$GLOBALS['Uphp']['urlInfo']['m']."/View/".$GLOBALS['Uphp']['urlInfo']['c']."/".$GLOBALS['Uphp']['urlInfo']['a'].Config::get("view_suffix");
        }

        $view = new View($tplFile, $this->viewVariable);
        return $view->show();
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