<?php
// 实例化model类
function model($moduleName){
    include_once(APP_DIR.'/'.$GLOBALS['uphp']['urlInfo']['m'].'/model/'.$moduleName.'Model.php');
    // 实例化
    $modelClass = 'app\index\model\\'.$moduleName.'Model';
    return new $modelClass();
}

// 获取配置或设置配置项
function config($key, $value){
    if(isset($value)){
        $GLOBALS['uphp'][$key] = $value;
    }else{
        return $GLOBALS['uphp'][$key];
    }
}
// 格式化输出
function d($value){
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}