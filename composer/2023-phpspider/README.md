# PhpSpider

使用 PhpSpider，根据状态指令自动爬取页面数据

## 起步

### 下载

```cmd
git clone git@github.com:langnang/phpspider-automation.git
```

### 安装依赖

```cmd
composer install
bower install
```

### 启动

start task

```shell
php -f main.php start [mode=create|insert|update] [id=...] [env=dev|prev|prod] [...]
```

start tasks

```shell
sh start.sh
```

## 目录结构

```txt
index.php # 页面
main.php # 主程序
helper.php # 工具函数
install.php # 安装页面
start.sh # 多程序启动脚本
task.json # 本地任务配置列表
```

## 生命周期钩子函数

- on_start: 爬虫初始化时调用
- on_fetch_url: 获取到 url 之后调用
  - on_fetch_scan_url
  - on_fetch_list_url
  - on_fetch_content_url
- on_download_page: 网页下载完成之后调用
  - on_scan_page: 在爬取到 url 的内容之后, 添加新的 url 到待爬队列之前调用
  - on_list_page: 在爬取到 url 的内容之后, 添加新的 url 到待爬队列之前调用
  - on_content_page: 在爬取到 url 的内容之后, 添加新的 url 到待爬队列之前调用
  - on_extract_field: 当一个 field 的内容被抽取到后调用
  - on_extract_page: 在一个网页的所有 field 抽取完成之后调用
- on_stop: 爬虫终止前调用
