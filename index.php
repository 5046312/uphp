<?php
# php入口文件
define('UPHP', true); // 确保入口

# 配置文件
define('APP_DEV', true); // 开发阶段
define('U_DIR', 'Uphp'); // 框架所在目录
define('APP_DIR', 'app'); // 应用所在目录
define("SESSION_DIR", "Cache/session"); // session存放位置

# 应用设置
define('START_MODULE', 'index'); // 默认模块
define('START_CONTROLLER', 'index'); // 默认控制器
define('START_ACTION', 'index'); // 默认方法

#   实例化入口
include(U_DIR."/Library/Uphp.php");
Uphp\Uphp::run();