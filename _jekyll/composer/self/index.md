---
title: Composer
---

- [开发手册](./dev-manual/)
- [服务手册](./ref-manual/)

## Illuminate

- Account: 账号
- Annotation: 注释
- [Application](./app.md): 应用启动器
  - Facade
  - Plugin
- Artisan
- ASCII
- Autoload
- Blade
- Broadcast
- Bus
- Cache
- Calendar: 日历
- Command
- [Config](): 配置
- Console
- Container
- Contract: 契约
- Controller: 控制器
- Cookie
- Crypt
- [Database](./database.md)
  - Schema
  - Table
  - Column
- Development: 开发
- DevTool: 开发控制台
- Eloquent: 数据库-模型关联
- Environment(env): 环境变量
- Err
- Event
- Facade
- Faker
- FFmpeg
- File
  - [Markdown](./file.markdown.md)
  - Html
  - Xlsx
  - Pdf  
  - Js
  - Css
  - Sql
  - Txt
  - Json
  - Zip
- FileSystem(fs)
- Ftp
- Hash
- Helper: 辅助函数
  - [Arr](./helper.arr.md): 数组
  - [Collection]
  - Date: 时间日期
  - [Str](./helper.str.md): 字符串
  - Filter: 过滤
- Http
  - Request
  - Response: 响应
- translation(i18n): 国际化
- Log: 日志
- Mail: 邮件
- [Model]
- [Modular](): 模块化
- Notification
- Operation: 运维
- Paginator: 数据库-数据分页
- Password
- Pipeline
- [Plugin](): 插件
- Process
- Query: 数据库-查询构造器
  - Builder
- Queue: 队列
- RateLimiter
- Redirect
- [RegExp](./reg-exp.md): 正则
  - Validator
- Router: 路由
- Schedule
- Schema: 架构
  - Migration
  - Seeder: 数据库-数据填充
- Session
- Spider: 数据采集
  - Selector: DOM 选择器
- Storage: 存储
- Traitor
- URL
  - Redirect: 重定向
- Usage
- User
  - Account
  - Auth: 安全-用户认证
  - Gate: 安全-用户授权
- Validation
- [VarDumper]
- [View](): 视图
- Yielder

### Facades

- Str

### Methods

- `make`
- `handle`
- `set`
- `get`
- `call`
- `singleton`
- `toArray`
- `toString`
- `toJson`
- `toHtml`
- `print`
- `dump`
- `registor`
- `bind`
- `boot`
- `abort`
- `flush`

#### MagicMethods

```php
function __construct(){}
function __clone(){}
function __call(){}
function __debugInfo(){}
function __get(){}
function __invoke(){}
function __isset(){}
function __serialize(){}
function __set(){}
function __unset(){}
/**
 * __sleep在一个对象序列化前调用，它不接收任何参数，但会返回数组
 */
function __sleep(){}
/**
 * 而__wakeup则相反，它是在反序列化前触发的
 * __wakeup()，执行unserialize()时，先会调用这个函数
 */
function __wakeup(){}
function __toString(){}

static function __callStatic(){}
```

#### LifeCycleMethods

```php
function _(){}
/**
 * 初始化
 */
function _init(){}
/**
 * 自动装载
 */
function _autoload(){}
/**
 * 运行化
 */
function _run(){}
/**
 * 标准化
 */
function _standard(){}
/**
 * 规则化
 */
function _validate(){}
/**
 * 日志化
 */
function _log(){}
/**
 * 调试
 */
function _debug(){}
/**
 * 打印
 */
function _print(){}
```
