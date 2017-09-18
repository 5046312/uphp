# uphp 
一个年轻的轻量级框架

## 说明
### 配置优先级
<p>框架配置 < 应用配置 < 模块配置 < 控制器配置 </p>
<p>相同配置会由高到低进行覆盖</p>

##  TODO
<ol>
<li>Exception class(Waiting for fix)</li>
<li>Language class(done)</li>
<li>Cookie class</li>
<li>Session class</li>
<li>Route class(Restful)</li>
<li>Cache class(File,Redis(done),Memcached)</li>
<li>File class</li>
<li>Image class(include Captcha)</li>
<li>Composer support(done)</li>
<li>A easy achieving View class</li>
<li>More database supporting(MongoDb...)</li>
<li>Better building and debug tools</li>
<li>Log generation(done)</li>
<li>Sql performance query and suggest to better </li>
<li>Create Module class</li>
<li>Swoole support</li>
<li>Wechat support</li>
</ol>

## Version collect
<p>v0.1 首次提交，本打算做一个精简的轻量框架</p>
<p>v0.2 初代版本功能较少，调试起来可能有些麻烦</p>
<p>v0.3 基本实现路由的访问来调用控制器方法</p>
<p>v0.4 修复框架在二级目录时Uri判定错误的bug</p>
<p>v0.5 Redis缓存类完成</p>
<p>v0.6 准备重写Model与Driver</p>
<p>v0.7 File日志可以记录每次Sql请求的信息（sql语句、执行时间）</p>
<p>v0.8 File日志增加文件锁，防止并发</p>