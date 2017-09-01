<?php
# 框架主体入口
defined("UPHP") or die;
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

# 引用公共函数
include(U_DIR.'/function/Common.php');

# 公共配置变量
config("urlInfo.m", $_GET['m'] ?: START_MODULE);
config("urlInfo.c", $_GET['c'] ?: START_CONTROLLER);
config("urlInfo.a", $_GET['a'] ?: START_ACTION);

# 引用控制器
include(APP_DIR.'/'.config("urlInfo.m").'/controller/'.config("urlInfo.c").'Controller'.'.php');
# 带命名空间类的实例化
$class = APP_DIR.'\\'.config("urlInfo.m").'\controller\\'.config("urlInfo.c").'Controller';
echo (new $class())->{config("urlInfo.a")}();
