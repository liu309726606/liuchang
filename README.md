# The framework named cube for the php.
* Single Kernel Mode.
* Author by linyang created on 2016-08.
* Version Alpha 0.0.1.
* 如果使用php做任务类功能,请使用linux自带的crontab -e 进行编辑,按照一定的频率进行.

### ./com - 框架级代码(勿动)
* /com/cube - cube框架包
* /com/cube/core - 核心类
* /com/cube/db - mysql orm
* /com/cube/error - 错误类
* /com/cube/framework - mvc框架
* /com/cube/fs - 文件操作
* /com/cube/http - http/https访问类
* /com/cube/international - 国际语言包处理类
* /com/cube/log - 日志类
* /com/cube/middleware - 中间件处理类
* /com/cube/utils - 工具包
* /com/cube/view - 模板引擎基类(EchoEngine和AngularEngine是默认实现的)

### ./internation - 国际化语言包存储目录

### ./log - 代码处理日志/mysql query sql 日志

### ./model - 框架proxy数据代理目录,主要用于数据库、文件等操作

### ./modules - 中间件/扩展插件

### ./router - 路由目录,相当于mvc框架的view层

### ./tmp - 文件缓存目录

### ./upload - 文件上传目录

### ./view - 模板存储目录

### ./package.json - 项目配置文件
*  dir - 功能目录
*  framework - 框架配置项
*  engine - 需要载入的html渲染器
*  modules - 需要载入的中间件
*  model - 初始化所有Proxy(但不是进行实例化)
*  router - 初始化所有Router Mediator(但不是进行实例化)

### ./www.php - 程序入口文件
