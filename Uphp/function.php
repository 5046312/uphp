<?php

/**
 * 引入自定义function文件
 * @param $name
 */
function getFunction($name){
    include_once(APP_DIR."/Function/".$name.".php");
}

/**
 * 获取配置或设置配置项
 * @param mixed $key 配置项名称
 * @param mixed $value 设置配置项
 * @return mixed
 */
function config($key, $value = NULL){
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
 * @param $type GET || POST
 * @param $url
 * @param $data
 * @return mixed
 */
function curl($type, $url, $data = null){

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不验证证书

    if($type == "POST"){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }else if($type == "GET"){
        curl_setopt($ch, CURLOPT_HEADER, 0);
    }

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
            $newUrl = "/indexController.php?m={$urlData[0]}".$paramData;
            break;
        case 2:
            $newUrl = "/indexController.php?m={$urlData[0]}&c={$urlData[1]}".$paramData;
            break;
        case 3:
            $newUrl = "/indexController.php?m={$urlData[0]}&c={$urlData[1]}&a={$urlData[2]}".$paramData;
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

/**
 * 引用Discuz更安全的加密方式
 * @param $string 明文 或 密文
 * @param string $operation DECODE表示解密,其它表示加密
 * @param int $expiry 密文有效期
 * @param string $key 密匙
 * @return string
 */
function authCode($string, $operation = 'DECODE',$expiry = 0, $key = 'UPHP') {
    $cKey_length = 4;
    $key = empty($key) ? md5(config("APP_ENCRYPT_KEY")) : md5($key);
    $keyA = md5(substr($key, 0, 16));
    $keyB = md5(substr($key, 16, 16));
    $keyC = $cKey_length ? ($operation == 'DECODE' ? substr($string, 0, $cKey_length): substr(md5(microtime()), -$cKey_length)) : '';
    $cryptKey = $keyA.md5($keyA.$keyC);
    $key_length = strlen($cryptKey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $cKey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyB), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndKey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndKey[$i] = ord($cryptKey[$i % $key_length]);
    }
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndKey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyB), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyC.str_replace('=', '', base64_encode($result));
    }
}
