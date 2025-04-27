# CHANGELOG

```sh
composer create-project --prefer-dist laravel/laravel Spider
```

```sh
npm install
```


```sh
# 创建迁移
php artisan make:migration create_spider_table

# 执行迁移
php artisan migrate
```

```sh
# 生成 Seeder
php artisan make:seeder SpiderSeeder

# 运行 Seeders
php artisan db:seed --class=SpiderSeeder

# 填充数据库
# php artisan migrate:fresh --seed
```

```sh
php artisan make:model SpiderMeta

php artisan make:model SpiderContent

php artisan make:model SpiderRelationShip
```


```sh
# 安装 dcat-admin
composer require dcat/laravel-admin:"2.*" -vvv
# 发布资源
php artisan admin:publish
# 安装
php artisan admin:install
```

```yml
# .env

ASSET_URL=/public
```
