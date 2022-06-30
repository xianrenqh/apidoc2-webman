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

