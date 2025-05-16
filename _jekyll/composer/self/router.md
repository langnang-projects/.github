# Route

## 基本路由

```php
Route::get('foo', function () {
    return 'Hello World';
});
```

**默认路由文件**

```php
// routes/web.php
// routes/api.php
```

**可用的路由方法**

```php
Route::get($uri, $callback);
Route::post($uri, $callback);
Route::put($uri, $callback);
Route::patch($uri, $callback);
Route::delete($uri, $callback);
Route::options($uri, $callback);
```

```php
Route::match(['get', 'post'], '/', function () {
    //
});

Route::any('/', function () {
    //
});
```

### 重定向路由

### 视图路由

```php
Route::view('/welcome', 'welcome');

Route::view('/welcome', 'welcome', ['name' => 'Taylor']);
```

## 路由参数

### 必填参数

```php
Route::get('user/{id}', function ($id) {
    return 'User '.$id;
});
```

```php
Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    //
});
```

### 可选参数

```php
Route::get('user/{name?}', function ($name = null) {
    return $name;
});

Route::get('user/{name?}', function ($name = 'John') {
    return $name;
});
```

### 正则表达式约束

```php
Route::get('user/{name}', function ($name) {
    //
})->where('name', '[A-Za-z]+');

Route::get('user/{id}', function ($id) {
    //
})->where('id', '[0-9]+');

Route::get('user/{id}/{name}', function ($id, $name) {
    //
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);
```

```php
Route::get('user/{id}/{name}', function ($id, $name) {
    //
})->whereNumber('id')->whereAlpha('name');

Route::get('user/{name}', function ($name) {
    //
})->whereAlphaNumeric('name');

Route::get('user/{id}', function ($id) {
    //
})->whereUuid('id');
```

**全局约束**

```php
/**
 *  定义你的路由模型绑定, pattern 过滤器等
 *
 * @return void
 */
public function boot()
{
    Route::pattern('id', '[0-9]+');
}
```

一旦定义好之后，便会自动应用这些规则到所有使用该参数名称的路由上：

```php
Route::get('user/{id}', function ($id) {
    //只有在 id 为数字时才执行...
});
```

## 路由命名

```php
Route::get('user/profile', function () {
    //
})->name('profile');
```

## 路由组

### 中间件

### 子域名路由

### 路由前缀

```php
Route::prefix('admin')->group(function () {
    Route::get('users', function () {
        // Matches The "/admin/users" URL
    });
});
```

### 路由名称前缀

```php
Route::name('admin.')->group(function () {
    Route::get('users', function () {
        // Route assigned name "admin.users"...
    })->name('users');
});
```

## 路由与模型绑定

### 隐式绑定

### 显式绑定

## 回退路由

## 限流

### 定义限流器

### 直接给路由配置限制

## 表单方法伪造

## 访问当前路由

## 跨域资源共享 (CORS)

## 参考手册

- https://learnku.com/docs/laravel/8.x/routing/9365
- [`symfony/routing`](https://packagist.org/packages/symfony/routing)
- [`nikic/fast-route`](https://packagist.org/packages/nikic/fast-route): Fast request router for PHP
