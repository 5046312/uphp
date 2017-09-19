# uphp 
一个年轻的轻量级框架

## 说明
### 配置优先级
框架配置 < 应用配置 < 模块配置 < 控制器配置
相同配置会由高到低进行覆盖

## DONE
+ Language class(done)
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