<?php
/**
 * route配置
 */
return [
    "GET" => [
        #访问URL     定位到控制器方法
        "a/b" => "index/index/index",
        "a/b/{c}" => ["index/index/index", ["c"=>"[0-9]+",]],
    ],

    "POST" => [

    ]
];