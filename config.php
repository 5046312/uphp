<?php
/**
 * 全局配置文件
 */
if(APP_DEV){
    # 开发阶段 环境配置
    return [
        #   基本配置
        "APP_TIMEZONE" => "PRC",
        "APP_LANGUAGE" => "ch", // 默认语言

        # 数据库配置
        "DB_HOST" => "127.0.0.1",
        "DB_PORT" => "3306",
        "DB_NAME" => "Uphp",
        "DB_USERNAME" => "root",
        "DB_PASSWORD" => "root",
        "DB_PREFIX" => "", // 数据表前缀

        # 模板配置
        "VIEW_SUFFIX" => ".html", // 模板文件后缀
        "VIEW_TAG_LEFT" => "@",
        "VIEW_TAG_RIGHT" => "@"
    ];
}else{
    # 生产阶段 环境配置
    return [
        #   基本配置
        "APP_TIMEZONE" => "PRC",
        "APP_LANGUAGE" => "ch", // 默认语言

        # 数据库配置
        "DB_HOST" => "127.0.0.1",
        "DB_PORT" => "3306",
        "DB_NAME" => "Uphp",
        "DB_USERNAME" => "root",
        "DB_PASSWORD" => "root",
        "DB_PREFIX" => "", // 数据表前缀

        # 模板配置
        "VIEW_SUFFIX" => ".html", // 模板文件后缀
        "VIEW_TAG_LEFT" => "@",
        "VIEW_TAG_RIGHT" => "@"
    ];
}
