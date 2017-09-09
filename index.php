<?php

#   载入公共函数
include('Uphp/function.php');

#   载入核心
include("Uphp/Library/Uphp.php");

$app = new \Uphp\Uphp();

define('APP_DIR', 'app'); // 应用所在目录

# 应用设置
define('START_MODULE', 'index'); // 默认模块
define('START_CONTROLLER', 'index'); // 默认控制器
define('START_ACTION', 'index'); // 默认方法

Uphp\Uphp::start();