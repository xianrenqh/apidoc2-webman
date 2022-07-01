# api-doc-Webman

webman 版本的 api-doc

扒拉的  **ThinkPHP ApiDoc** ，改成了webman版本的，部分功能可能无法使用（去掉了缓存、多语言）。

ThinkPHP ApiDoc官网：

https://hg-code.gitee.io/thinkphp-apidoc/guide/

## 安装

> composer require xianrenqh/apidoc2-webman

## 访问：

文档默认地址为：

http://127.0.0.1:8787/apidoc/index.html

可以在config里面进行更改路由：

**路由配置文件地址：**

\config\plugin\xianrenqh\apidoc2-webman\route.php

**apidoc基本配置文件：**

config/plugin/xianrenqh/apidoc2-webman/apidoc.php

## Nginx反向代理问题

解决nginx反向代理后页面上的js/css文件无法加载的方法：

问题现象：

nginx配置反向代理后，网页可以正常访问，但是页面上的js、css和图片等资源都无法访问。

* （1）nginx配置如下：
* （2）域名访问：js css文件无法加载；
* （3）IP访问：js css文件可以正常加载；
* （4）CI框架下无法访问

解决方法：

nginx配置文件中，修改为如下配置：

（宝塔的话：找到站点，设置，配置文件里修改）

```
location ~ \.php$ {
                proxy_pass http://127.0.0.1:8787;
                include naproxy.conf;
        }
        location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$ {
                expires      30d;
                proxy_pass http://127.0.0.1:8787;
                include naproxy.conf;
        }

        location ~ .*\.(js|css)?$ {
                expires      12h;
                proxy_pass http://127.0.0.1:8787;
                include naproxy.conf;
        }
```

需要把静态文件也添加反向代理设置。

## 简单使用案例：

官网教程地址：

https://hg-code.gitee.io/thinkphp-apidoc/use/



### 1、编辑apidoc.php文件：
找到config/plugin/xianrenqh/apidoc2-webman/apidoc.php文件并编辑：

编辑 apps键（大概第13行-20行）

增加你需要的api的controllers控制器
例如：
```
'controllers' => [
    'app\api\controller\UserController',
],
```

### 2、在控制器中添加注解
打开控制器：
app\api\controller\UserController

#### 引入解释文件
注意：在官网中引用的是：

**use hg\apidoc\annotation as Apidoc;**

我们不要引入上面的， 要引入下面的：

~~~
use xianrenqh\Apidoc2Webman\annotation as Apidoc;
~~~

换句话说， 官网只要是
**use hg\apidoc\annotation**，
我们都要替换为：
> use xianrenqh\Apidoc2Webman\annotation


#### 控制器注释
为控制器加上一些注释，以让文档可读性更高（当然这不是必须的）
```php
<?php
namespace app\controller;
use xianrenqh\Apidoc2Webman\annotation as Apidoc;

/**
 * 标题也可以这样直接写
 * @Apidoc\Title("基础示例")
 * @Apidoc\Group("base")
 * @Apidoc\Sort(1)
 */
class ApiDocTest
{
  //...    
}
```
#### 接口注释
控制器中的每一个符合注释规则的方法都会被解析成一个API接口

基础注释

```php
<?php

use xianrenqh\Apidoc2Webman\annotation as Apidoc;

/**
 * @Apidoc\Title("基础示例")
 */
class ApiDocTest
{ 
    /**
     * @Apidoc\Title("基础的注释方法")
     * @Apidoc\Desc("最基础的接口注释写法")
     * @Apidoc\Url("/api.html")
     * @Apidoc\Method("GET")
     * @Apidoc\Author("HG-CODE")
     * @Apidoc\Tag("测试")
     * @Apidoc\Param("username", type="abc",require=true, desc="用户名")
     * @Apidoc\Param("password", type="string",require=true, desc="密码")
     * @Apidoc\Param("phone", type="string",require=true, desc="手机号")
     * @Apidoc\Param("sex", type="int",default="1",desc="性别" )
     * @Apidoc\Returned("id", type="int", desc="用户id")
     */
    public function base(){
        //...
    }
  
}
```

其他参数请在原官网上查看， 这里就不列举了：

https://hg-code.gitee.io/thinkphp-apidoc/use/notes/api/#%E5%8F%82%E6%95%B0%E8%AF%B4%E6%98%8E



## ✨特性

- 开箱即用：无繁杂的配置、安装后按文档编写注释即可自动生成API文档。
- 在线调试：在线文档可直接调试，支持全局参数、Mock调试数据、事件执行，接口调试省时省力。
- 轻松使用：支持公共注释定义、业务逻辑层、数据表字段等引用，几句注释即可完成。
- 安全高效：支持访问密码验证、应用/版本独立密码。
- 多应用/多版本：可适应各种单应用、多应用、多版本的项目的Api管理。
- Markdown文档：支持.md文件的文档展示。
- 控制器分组：支持控制器多级分组，更精细化管理接口目录。
-

## 📖使用文档

[ThinkPHP ApiDoc V3.x文档](https://hg-code.gitee.io/thinkphp-apidoc/)

