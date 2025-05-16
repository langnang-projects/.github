# Database

## 简介

### 使用多数据库连接

```php
DB::connection('foo')->select(...);
```

## Adapters

## Traits

## Facades

### Facades/DB

- `connection($name = null)`: 链接数据库

- `insert`: 执行 Insert 语句
- `delete`: 执行 Delete 语句
- `update`: 执行 Update 语句
- `select`: 执行 Select 语句
- `statement`: 执行普通语句
- `unprepared`: 运行未预处理的语句
- `transaction`: 数据库事务

- `table`: 为给定的表返回一个查询构造器实例
- `first`: 从数据表中获取一行数据
- `value`: 从记录中获取单个值
- `find`: 通过 id 字段值获取一行数据
- `pluck`: 获取单列数据的集合
- `chunk`
- `chunkById`
- `orderBy`
- `where`
- `get`

### Facades/Schema

### 链接数据库

#### `connection($name = null)`

```php
DB::connection();
```

### 执行原生 SQL 查询

#### `insert`

> `原生SQL`：执行 Insert 查询

```php
DB::insert('insert into users (id, name) values (?, ?)', [1, 'Dayle']);
```

#### `delete`

> 执行 Delete 查询

```php
$deleted = DB::delete('delete from users');
```

#### `update`

> 执行 Update 查询

```php
$affected = DB::update('update users set votes = 100 where name = ?', ['John']);
```

#### `select`

> 执行 Select 查询

```php
DB::select('select * from users where active = ?', [1])
```

#### `statement`

> 执行普通语句
> 有些数据库语句不会有任何返回值。对于这些语句，你可以使用 DB Facade 的 statement 方法来运行：

```php
DB::statement('drop table users');
```

#### `unprepared`

> 运行未预处理的语句
> 有时你可能希望在不绑定任何值的情况下运行语句。对于这些类型的操作，可以使用 DB Facade 的 unprepared 方法：

```php
DB::unprepared('update users set votes = 100 where name = "Dries"');

DB::unprepared('create table a (col varchar(1) null)');
```

#### 查询构造器

#### `table`

#### 分页
