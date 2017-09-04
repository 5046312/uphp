<?php
/**
 * 全局配置文件
 */
if(APP_DEV){
    # 开发阶段 环境配置
    return [
        #   基本配置
        "app" => [
            "timezone" => "PRC",
            "language" => "ch", // 默认语言
            "encrypt_key" => "UPHP", // 加密函数密钥
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

        #   模板配置
        "view" => [
            "suffix" => ".html", // 模板文件后缀
            "tag_left" => "@",
            "tag_right" => "@"
        ]
    ];
}else{
    # 生产阶段 环境配置
    return [

    ];
}
