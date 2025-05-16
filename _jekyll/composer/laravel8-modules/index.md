---
title: Laravel8 Modules
---

## 数据表设计

#### Table `_metas`

|列名|类型|为空|主键|默认|注释|
|--|--|--|--|--|--|
|mid|int(10)|false|1||编号|
|ico|varchar(255)|true|||徽标|
|slug|varchar(255)|true|||标识|
|name|varchar(255)|true|||名称|
|description|varchar(255)|true|||描述|
|type|varchar(25)|true|||类型|
|status|varchar(25)|true|||状态|
|parent|int(10)|true|||父本|
|order|int(10)|true|||排序权重|
|count|int(10)|true|||计数|
|created_at|timestamp|true|||创建时间|
|updated_at|timestamp|true|||更新时间|
|release_at|timestamp|true|||发布时间|
|deleted_at|timestamp|true|||删除时间|

```sql
-- MySQL
CREATE TABLE `_metas`();
```

#### Table `_contents`

#### Table `_links`

#### Table `_relationships`

## 数据流图设计

## 业务流图设计

## 功能设计开发

### 模块依赖注入
