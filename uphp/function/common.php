<?php
// 实例化model类
function model($moduleName){
    include_once(APP_DIR.'/'.$GLOBALS['uphp']['urlInfo']['m'].'/model/'.$moduleName.'Model.php');
    // 实例化
    $modelClass = 'app\index\model\\'.$moduleName.'Model';
    return new $modelClass($moduleName);
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
// curl get
function curlGet($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    return ($output);
}
// curl post
function curlPost($url, $data){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $output = curl_exec($ch);
    curl_close($ch);
    return ($output);
}

function __autoload($className){
    include_once($className.'.php');
}