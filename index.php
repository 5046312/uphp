<?php


#   必须在载入前定义应用和框架所在目录
define("APP_DIR", "app");
define("UPHP_DIR", "Uphp");

#   载入框架公共函数
include(UPHP_DIR.'/function.php');
#   载入框架核心
include(UPHP_DIR."/Library/Uphp.php");

#   实例化调用启动方法
$appClass = UPHP_DIR."\\Uphp";
$app = (new $appClass)->start();
