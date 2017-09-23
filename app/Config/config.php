<?php
/**
 * 应用全局配置，优先级低于分层控制器配置
 */
return [
    #   数据库配置
    "db" => [
        "type" => "mysql", // 默认数据库类型（非连接形式），后面可自定义参数实例化
        "host" => "127.0.0.2",
        "port" => "3306",
        "name" => "Uphp", // 数据库名
        "username" => "root",
        "password" => "root",
        "prefix" => "uphp_", // 数据表前缀
    ],
];