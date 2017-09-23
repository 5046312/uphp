# uphp 
一个年轻的轻量级框架

## 说明
### 配置优先级
框架配置 < 应用配置 < 模块配置 < 控制器配置
相同配置会由高到低进行覆盖

## OpenWeChat
被动回复用户消息的数组模板：

文字 text:
```
$text = [
            "MsgType" => "text", // * 消息类型
            "Content" => "", // * 发送的文字内容（支持换行）
        ];
```
图片 image:
```
$image = [
            "MsgType" => "image", // * 消息类型
            "MediaId" => "", // * 通过素材管理中的接口上传多媒体文件，得到的id。
        ];
```
语音 voice:
```
$voice = [
            "MsgType" => "voice", // * 消息类型
            "MediaId" => "", // * 通过素材管理中的接口上传多媒体文件，得到的id
        ];
```
视频 video:
```
$video = [
            "MsgType" => "video", // * 消息类型
            "MediaId" => "", // * 通过素材管理中的接口上传多媒体文件，得到的id
            "Title" => "", // 视频消息的标题
            "Description" => "", // 视频消息的描述
        ];
```
音乐 music:
```
$music = [
            "MsgType" => "music", // * 消息类型
            "ThumbMediaId" => "", // * 缩略图的媒体id，通过素材管理中的接口上传多媒体文件，得到的id
            "Title" => "", // 音乐标题
            "Description" => "", // 音乐描述
            "MusicURL" => "", // 音乐链接
            "HQMusicUrl" => "", // 高质量音乐链接，WIFI环境优先使用该链接播放音乐
        ];
```
图文 news: // Todo: 可发送多条内容（尚未完成）
```
$news = [
            "MsgType" => "news", // * 消息类型
            "ArticleCount" => "", // * 图文消息个数，限制为8条以内
            "Articles" =>
            [
                [
                    "Title" => "", // 图文消息标题
                    "Description" => "", // 图文消息描述
                    "PicUrl" => "", // 图片链接，支持JPG、PNG格式，较好的效果为大图360*200，小图200*200
                    "Url" => "", // 点击图文消息跳转链接
                ],
                ...
            ]
        ];
```

## DONE
+ Language class(done)
+ Config class(done)
+ Composer support(done)
+ Log generation(done)

##  TODO
+ Cookie class
+ Session class
+ Exception class(Waiting for fix)
+ Route class(Restful)
+ Cache class(File(done), Redis(done), Memcached)
+ File class
+ Image class(include Captcha)
+ A easy achieving View class
+ More database supporting(MongoDb...)
+ Better building and debug tools
+ Sql performance query and suggest to better
+ Create Module class
+ Swoole support
+ WeChat support


## Version collect
+ v0.1 首次提交，本打算做一个精简的轻量框架
+ v0.2 初代版本功能较少，调试起来可能有些麻烦
+ v0.3 基本实现路由的访问来调用控制器方法
+ v0.4 修复框架在二级目录时Uri判定错误的bug
+ v0.5 Redis缓存类完成
+ v0.6 准备重写Model与Driver
+ v0.7 File日志可以记录每次Sql请求的信息（sql语句、执行时间）
+ v0.8 File日志增加文件锁，防止并发
+ v0.9 彻底解决了框架在多级目录下路由无法正确定位的BUG
+ v0.10 日志写入放在了register_shutdown_function这个类似析构方法中
+ v0.11 新增OpenWeChat类，实现Access_Token的获取、保存、日志记录
+ v0.12 修复Linux路径不兼容问题，修复框架在N层目录下访问错误的BUG
+ v0.13 完成配置载入优先级，逐级覆盖