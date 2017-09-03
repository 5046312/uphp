<?php
/**
 * 获取配置或设置配置项
 * @param $key 配置项名称
 * @param $value 设置配置项
 * @return mixed
 */
function config($key, $value){
    if(isset($value)){
        \Uphp\Config::set($key, $value);
    }else{
        return \Uphp\Config::get($key);
    }
}

/**
 * 格式化输出
 * @param $value
 */
function p($value){
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

/**
 * curl get
 * @param $url
 * @return mixed
 */
function curlGet($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    return ($output);
}

/**
 * curl post
 * @param $url
 * @param $data
 * @return mixed
 */
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

/**
 * 页面跳转
 * @param $url 完整URL
 * @param $refresh 等待时间
 * @param $info 等待时页面显示内容
 */
function jump($url, $refresh, $info){
    if(is_null($refresh)){
        header("Location:.{$url}");
    }else{
        echo"<meta http-equiv=\"refresh\" content=".$refresh.";URL=.".$url.">";
        echo $info;
    }
    die;
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

/**
 * XML编码
 * @param mixed $data 数据
 * @param string $root 根节点名
 * @param string $item 数字索引的子节点名
 * @param string $attr 根节点属性
 * @param string $id   数字索引子节点key转换的属性名
 * @param string $encoding 数据编码
 * @return string
 */
function xmlEncode($data, $root='Uphp', $item='item', $attr='', $id='id', $encoding='utf-8') {
    if(is_array($attr)){
        $_attr = array();
        foreach ($attr as $key => $value) {
            $_attr[] = "{$key}=\"{$value}\"";
        }
        $attr = implode(' ', $_attr);
    }
    $attr   = trim($attr);
    $attr   = empty($attr) ? '' : " {$attr}";
    $xml    = "<?xml version=\"1.0\" encoding=\"{$encoding}\"?>";
    $xml   .= "<{$root}{$attr}>";
    $xml   .= dataToXml($data, $item, $id);
    $xml   .= "</{$root}>";
    return $xml;
}

/**
 * 数据XML编码
 * @param mixed  $data 数据
 * @param string $item 数字索引时的节点名称
 * @param string $id   数字索引key转换为的属性名
 * @return string
 */
function dataToXml($data, $item='item', $id='id') {
    $xml = $attr = '';
    foreach ($data as $key => $val) {
        if(is_numeric($key)){
            $id && $attr = " {$id}=\"{$key}\"";
            $key  = $item;
        }
        $xml    .=  "<{$key}{$attr}>";
        $xml    .=  (is_array($val) || is_object($val)) ? dataToXml($val, $item, $id) : $val;
        $xml    .=  "</{$key}>";
    }
    return $xml;
}