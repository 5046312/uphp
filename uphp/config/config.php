<?php
/**
 * 全局配置文件
 */
if(APP_DEV){
    # 开发阶段 环境配置
    return [
        # 数据库配置
        "db_host" => "127.0.0.1",
        "db_port" => "3306",
        "db_name" => "uphp",
        "db_username" => "root",
        "db_password" => "root",
        "db_prefix" => "", // 数据表前缀

        # 模板配置
        "view_suffix" => ".html", // 模板文件后缀
        "view_tag_left" => "@",
        "view_tag_right" => "@"
    ];
}else{
    # 生产阶段 环境配置
    return [
        # 数据库配置
        "db_host" => "127.0.0.1",
        "db_port" => "3306",
        "db_name" => "uphp",
        "db_username" => "root",
        "db_password" => "root",
        "db_prefix" => "", // 数据表前缀

        # 模板配置
        "view_suffix" => ".html", // 模板文件后缀
        "view_tag_left" => "@",
        "view_tag_right" => "@"
    ];
}
