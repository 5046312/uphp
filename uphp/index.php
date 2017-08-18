<?php

# 框架主体文件
defined("UPHP") or die;
error_reporting(E_ALL ^ E_NOTICE);

# 引用公共函数
include(U_DIR.'/function/common.php');

$urlInfo['m'] = $_GET['m'] ?: START_MODULE;
$urlInfo['c'] =  $_GET['c'] ?: START_CONTROLLER;
$urlInfo['a'] =  $_GET['a'] ?: START_ACTION;

// 引入控制器基类
include(U_DIR.'/lib/Controller.php');

// 引用控制器
include(APP_DIR.'/'.$urlInfo['m'].'/controller/'.$urlInfo['c'].'Controller'.'.php');
// 带命名空间类的实例化
$class = APP_DIR.'\\'.$urlInfo['c'].'\controller\\'.$urlInfo['c'].'Controller';
$controller = new $class();
$action = $controller->$urlInfo['a']();
