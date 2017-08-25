<?php
# 框架主体入口
defined("UPHP") or die;
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

# 引用公共函数
include(U_DIR.'/function/common.php');

# 公共配置变量
$GLOBALS['uphp']['urlInfo']['m'] = $_GET['m'] ?: START_MODULE;
$GLOBALS['uphp']['urlInfo']['c'] =  $_GET['c'] ?: START_CONTROLLER;
$GLOBALS['uphp']['urlInfo']['a'] =  $_GET['a'] ?: START_ACTION;

// 加载数据库设置
$GLOBALS['uphp']['db'] = include(CONFIG_DIR.'/database.php');

// 引入Db基类
include(U_DIR.'/lib/Mysql.php');
// 引入Model基类
include(U_DIR.'/lib/Model.php');
// 引入控制器基类
include(U_DIR.'/lib/Controller.php');
// 引用控制器
include(APP_DIR.'/'.$GLOBALS['uphp']['urlInfo']['m'].'/controller/'.$GLOBALS['uphp']['urlInfo']['c'].'Controller'.'.php');
// 带命名空间类的实例化
$class = APP_DIR.'\\'.$GLOBALS['uphp']['urlInfo']['c'].'\controller\\'.$GLOBALS['uphp']['urlInfo']['c'].'Controller';
$controller = new $class();
$action = $controller->$GLOBALS['uphp']['urlInfo']['a']();
