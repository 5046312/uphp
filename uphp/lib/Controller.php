<?php
namespace uphp;
// 控制器基类
class Controller
{
    public $viewVariable = []; // 模板变量


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
        // 附带变量渲染模板
        if(!empty($data)){
            foreach($data as $k=>$v){
                $this->viewVariable[$k] = $v;
            }
        }
        // 指定输出模板
        if(!empty($tpl)){
            # $tpl "index" or "hello/asd"
            if(strpos($tpl, "/")){
                $tpl = explode("/", $tpl);
                $tplFile = "./".APP_DIR."/".$GLOBALS['uphp']['urlInfo']['m']."/view/".$tpl[0]."/".$tpl[1].config("view_suffix");
            }else{
                $tplFile = "./".APP_DIR."/".$GLOBALS['uphp']['urlInfo']['m']."/view/".$GLOBALS['uphp']['urlInfo']['c']."/".$tpl.config("view_suffix");
            }
        }else{
            # empty to find same action template
            $tplFile = "./".APP_DIR."/".$GLOBALS['uphp']['urlInfo']['m']."/view/".$GLOBALS['uphp']['urlInfo']['c']."/".$GLOBALS['uphp']['urlInfo']['a'].config("view_suffix");
        }

        $view = new View($tplFile, $this->viewVariable);
        return $view->show();
    }
}