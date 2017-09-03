<?php
# 框架主体入口
defined("UPHP") or die;
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

# 引用公共函数
include(U_DIR.'/function/Common.php');

# 公共配置变量
define("_MODULE_", $_GET['m'] ?: START_MODULE);
define("_CONTROLLER_", $_GET['c'] ?: START_CONTROLLER);
define("_ACTION_", $_GET['a'] ?: START_ACTION);

#   实例化入口
include(U_DIR."/library/Uphp.php");

Uphp\Uphp::getInstance();
