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

function ajaxOut($data){
    echo json_encode($data);
    die;
}

function jump($url, $refresh, $info){
    if(is_null($refresh)){
        header("Location:$url");
    }else{
        echo"<meta http-equiv=\"refresh\" content=".$refresh.";URL=".$url.">";
        echo $info;
    }
    return;
}

/**
 * 生成url
 * @param $url
 * @param $param
 * @return bool|string
 */
function url($url, $param){
    $urlData = explode("/", $url);
    if(!empty($param)){
        $paramData = "&";
        foreach ($param as $k=>$v){
            $paramData .= "{$k}={$v}&";
        }
        $paramData = rtrim($paramData, "&");
    }
    switch (count($urlData)){
        case 1:
            $newUrl = "/index.php?m={$urlData[0]}".$paramData;
            break;
        case 2:
            $newUrl = "/index.php?m={$urlData[0]}&c={$urlData[1]}".$paramData;
            break;
        case 3:
            $newUrl = "/index.php?m={$urlData[0]}&c={$urlData[1]}&a={$urlData[2]}".$paramData;
            break;
        default:
            return false;
    }
    return $newUrl;
}

function __autoload($className){
    include_once($className.'.php');
}