<?php

namespace Langnang\PhpServer;

class Model
{
  /**
   * 构造方法
   */
  function __construct($model, $strict = true, ...$args)
  {
    // foreach (get_class_vars(__CLASS__) as $name => $default_value) {
    //   if (is_array($default_value) && is_string($model[$name])) {
    //     $model[$name] = json_decode($model[$name], true);
    //   }
    //   if (is_bool($default_value) && is_string($model[$name])) {
    //     $model[$name] = (bool)$model[$name];
    //   }
    //   if (is_int($default_value) && is_string($model[$name])) {
    //     $model[$name] = (int)$model[$name];
    //   }
    // }

    if (!empty($model)) {
      foreach ($model as $name => $value) {
        if ($strict) {
          if (array_key_exists($name, get_class_vars(static::class))) {
            $this->__set($name, $value);
          }
        } else {
          $this->__set($name, $value);
        }
      }
    }
    if (method_exists($this, '__self__construct')) {
      $this->{'__self__construct'}($model, ...$args);
    }
  }
  /**
   * 
   */
  function __set($name, $value)
  {
    // if (!property_exists($this, $name)) {
    //   return;
    // }
    // 保持数据类型一致
    // $default_value = $this->{$name};
    // // 如果为null 或未设置默认值 || 类型一致
    // if (is_null($default_value) || lnFunction::get_var_type($value) === lnFunction::get_var_type($default_value)) {
    //   $this->{$name} = $value;
    // } else {
    //   switch (lnFunction::get_var_type($value)) {
    //     case 'string':
    //       $value = call_user_func([lnString::class, "to_" . lnFunction::get_var_type($default_value)], $value);
    //       break;
    //     case 'array':
    //       $value = call_user_func([lnArray::class, "to_" . lnFunction::get_var_type($default_value)], $value);
    //       break;
    //     default:
    //       break;
    //   }
    //   $this->{$name} = $value;
    // }
    // 判断存在自定义函数
    if (method_exists($this, 'set' . $name)) {
      $this->{'set' . $name}($value);
    } else if (method_exists($this, 'set_' . $name)) {
      $this->{'set_' . $name}($value);
    } else {
      $this->{$name} = $value;
    }
  }
  /**
   * 
   */
  function __get($name)
  {
    if (method_exists($this, 'get' . $name)) {
      return $this->{'get' . $name}();
    } else if (method_exists($this, 'get_' . $name)) {
      return $this->{'get_' . $name}();
    } else if (!isset($this->{$name})) return;
    return $this->{$name};
  }

  function __to_array($depth = true)
  {
    $result = json_decode(json_encode($this, JSON_UNESCAPED_UNICODE), true);
    if (!$depth) {
      foreach ($result as $name => $value) {
        if (is_array($value)) {
          $result[$name] = addslashes(json_encode($value, JSON_UNESCAPED_UNICODE));
        }
      }
    }
    return $result;
  }
}
