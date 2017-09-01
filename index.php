<?php
# php入口文件
define('UPHP', true); // 确保入口

# 配置文件
define('U_DIR', 'uphp'); // 框架所在目录
define('APP_DIR', 'app'); // 应用所在目录
define('CONFIG_DIR', 'config'); // 应用设置目录

# 应用设置
define('START_MODULE', 'index'); // 默认模块
define('START_CONTROLLER', 'index'); // 默认控制器
define('START_ACTION', 'index'); // 默认方法
require('./uphp/index.php');