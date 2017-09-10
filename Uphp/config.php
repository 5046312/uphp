<?php
/**
 * 全局配置文件
 */
return [
    #   基本配置
    "app" => [
        "debug" => true, // debug开发阶段
        "default_module" => "index", // 默认控制器
        "default_controller" => "index", // 默认控制器
        "default_action" => "index", // 默认方法
        "timezone" => "PRC",
        "language" => "ch", // 默认语言包
        "encrypt_key" => "UPHP", // 加密函数密钥
    ],

    #   路径设置
    "dir" => [
        "application" => "app", //  应用所在目录
        "framework" => "Uphp",  //  框架所在目录
    ],

    #   URL设置
    "url" => [
        "must_prefix" => true, // 强制访问后缀（路由规则中无需添加）
        "prefix" => ".html", // url后缀
        "both_type" => true, // 两种路由形式是否同时开启（false时只支持/分割形式，不支持?m=index&c=index&a=index形式，注意：两种模式并不能混用有/则无法用get定位）
    ],

    #   数据库配置
    "db" => [
        "host" => "127.0.0.1",
        "port" => "3306",
        "name" => "Uphp", // 数据库名
        "username" => "root",
        "password" => "root",
        "prefix" => "uphp_", // 数据表前缀
    ],

    #   Cookie配置
    "cookie" => [
        "expire" => "", // 规定 cookie 的有效期
        "path" => "", // 规定 cookie 的服务器路径
        "domain" => "", // 规定 cookie 的域名
        "secure" => "", // 规定是否通过安全的 HTTPS 连接来传输 cookie。
    ],
    #   Session配置
    "session" => [
        "dir" => "cache/session" // session存放位置
    ],
    #   模板配置
    "view" => [
        "suffix" => ".html", // 模板文件后缀
        "tag_left" => "@",
        "tag_right" => "@"
    ],

    #   日志配置
    "log" => [
        "open" => true, // 开启日志
        "type" => "file",
        "error_level" => E_WARNING, // 错误记录级别
        "file" => [
            "date_format" => "Y-m-d", // 日志文件命名格式
            "dir" => "cache/log", // 日志文件存放路径
            "suffix" => ".txt", // 日志文件后缀
        ],
    ],
];
