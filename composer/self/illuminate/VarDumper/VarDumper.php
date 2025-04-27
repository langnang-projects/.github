<?php

namespace Illuminate\VarDumper;

class VarDumper extends \Core\Illuminate
{
  private $aliases = [
    "summary" => "",
  ];

  function make() {}

  function print($trace)
  {
    $return = '';
    // var_dump($trace);
    $file = $trace['file'];
    $line = $trace['line'];
    $args = $trace['args'];
    foreach ($args as $arg) {
      $return .= "<pre style='" . $this->getElementStyles('container') . "'>";
      switch (gettype($arg)) {
        case "array":
        case "object":
          $return .= "<details open>"
            . "<summary>"
            . "<font style='" . $this->getElementStyles('summary') . "'>$file: $line: </font>"
            . "</summary>"
            . $this->print_type($arg)
            . "</details>";
          break;
        default:
          $return .= "<font style='" . $this->getElementStyles('summary') . "'>$file: $line: </font>" .
            $this->print_type($arg);
          break;
      }
      $return .=  "</pre>";
    }

    if (config('this.visible')) echo $return;
  }
  function print_type($value, $depth = 0)
  {
    $max_depth = config('this.max_depth');
    $return = '';
    // var_dump(gettype($value));
    switch (gettype($value)) {
      case 'object':
        if ($depth > $max_depth) return;
        $class = get_class($value);
        $reflection = new \ReflectionClass($class);
        // $reflection = $reflection->newInstance((array)$value);
        ([
          "value" => $value,
          // ReflectionClass::__construct — 初始化 ReflectionClass 类
          // "__construct" => $reflection->__construct(),
          // ReflectionClass::export — 导出类
          // "export" => $reflection->export(),
          // ReflectionClass::getAttributes — 获取所有属性
          // "getAttributes" => $reflection->getAttributes(),
          // ReflectionClass::getConstant — 获取已定义的常量
          // "getConstant" => $reflection->getConstant(),
          // ReflectionClass::getConstants — 获取常量
          "getConstants" => $reflection->getConstants(),
          // ReflectionClass::getConstructor — 获取类的构造函数
          "getConstructor" => $reflection->getConstructor(),
          // ReflectionClass::getDefaultProperties — 获取默认属性
          "getDefaultProperties" => $reflection->getDefaultProperties(),
          // ReflectionClass::getDocComment — 获取文档注释
          "getDocComment" => $reflection->getDocComment(),
          // ReflectionClass::getEndLine — 获取最后一行的行数
          "getEndLine" => $reflection->getEndLine(),
          // ReflectionClass::getExtension — 根据已定义的类获取所在扩展的 ReflectionExtension 对象
          "getExtension" => $reflection->getExtension(),
          // ReflectionClass::getExtensionName — 获取定义的类所在的扩展的名称
          "getExtensionName" => $reflection->getExtensionName(),
          // ReflectionClass::getFileName — 获取定义类的文件名
          "getFileName" => $reflection->getFileName(),
          // ReflectionClass::getInterfaceNames — 获取接口（interface）名称
          "getInterfaceNames" => $reflection->getInterfaceNames(),
          // ReflectionClass::getInterfaces — 获取接口
          "getInterfaces" => $reflection->getInterfaces(),
          // ReflectionClass::getMethod — 获取类方法的 ReflectionMethod
          // "getMethod" => $reflection->getMethod(),
          // ReflectionClass::getMethods — 获取方法的数组
          "getMethods" => $reflection->getMethods(),
          // ReflectionClass::getModifiers — 获取类的修饰符
          "getModifiers" => $reflection->getModifiers(),
          // ReflectionClass::getName — 获取类名
          "getName" => $reflection->getName(),
          // ReflectionClass::getNamespaceName — 获取命名空间的名称
          "getNamespaceName" => $reflection->getNamespaceName(),
          // ReflectionClass::getParentClass — 获取父类
          "getParentClass" => $reflection->getParentClass(),
          // ReflectionClass::getProperties — 获取属性
          "getProperties" => $reflection->getProperties(),
          // ReflectionClass::getProperty — 获取类的一个属性的 ReflectionProperty
          // "getProperty" => $reflection->getProperty(),
          // ReflectionClass::getReflectionConstant — Gets a ReflectionClassConstant for a class's constant
          // "getReflectionConstant" => $reflection->getReflectionConstant(),
          // ReflectionClass::getReflectionConstants — Gets class constants
          "getReflectionConstants" => $reflection->getReflectionConstants(),
          // ReflectionClass::getShortName — 获取短名
          "getShortName" => $reflection->getShortName(),
          // ReflectionClass::getStartLine — 获取起始行号
          "getStartLine" => $reflection->getStartLine(),
          // ReflectionClass::getStaticProperties — 获取静态（static）属性
          "getStaticProperties" => $reflection->getStaticProperties(),
          // ReflectionClass::getStaticPropertyValue — 获取静态（static）属性的值
          // "getStaticPropertyValue" => $reflection->getStaticPropertyValue(),
          // ReflectionClass::getTraitAliases — 返回 trait 别名数组
          "getTraitAliases" => $reflection->getTraitAliases(),
          // ReflectionClass::getTraitNames — 返回这个类所使用 traits 的名称的数组
          "getTraitNames" => $reflection->getTraitNames(),
          // ReflectionClass::getTraits — 返回这个类所使用的 traits 数组
          "getTraits" => $reflection->getTraits(),
          // ReflectionClass::hasConstant — 检查常量是否已经定义
          // "hasConstant" => $reflection->hasConstant(),
          // ReflectionClass::hasMethod — 检查方法是否已定义
          // "hasMethod" => $reflection->hasMethod(),
          // ReflectionClass::hasProperty — 检查属性是否已定义
          // "hasProperty" => $reflection->hasProperty(),
          // ReflectionClass::implementsInterface — 实现接口
          // "implementsInterface" => $reflection->implementsInterface(),
          // ReflectionClass::inNamespace — 检查是否位于命名空间中
          "inNamespace" => $reflection->inNamespace(),
          // ReflectionClass::isAbstract — 检查类是否是抽象类（abstract）
          "isAbstract" => $reflection->isAbstract(),
          // ReflectionClass::isAnonymous — 检查类是否是匿名类
          "isAnonymous" => $reflection->isAnonymous(),
          // ReflectionClass::isCloneable — 返回了一个类是否可复制
          "isCloneable" => $reflection->isCloneable(),
          // ReflectionClass::isEnum — Returns whether this is an enum
          // "isEnum" => $reflection->isEnum(),
          // ReflectionClass::isFinal — 检查类是否声明为 final
          "isFinal" => $reflection->isFinal(),
          // ReflectionClass::isInstance — 检查类的实例
          // "isInstance" => $reflection->isInstance(),
          // ReflectionClass::isInstantiable — 检查类是否可实例化
          "isInstantiable" => $reflection->isInstantiable(),
          // ReflectionClass::isInterface — 检查类是否是一个接口（interface）
          "isInterface" => $reflection->isInterface(),
          // ReflectionClass::isInternal — 检查类是否由扩展或核心在内部定义
          "isInternal" => $reflection->isInternal(),
          // ReflectionClass::isIterable — Check whether this class is iterable
          "isIterable" => $reflection->isIterable(),
          // ReflectionClass::isIterateable — 别名 ReflectionClass::isIterable
          "isIterateable" => $reflection->isIterateable(),
          // ReflectionClass::isReadOnly — Checks if class is readonly
          "getName" => $reflection->getName(),
          // ReflectionClass::isSubclassOf — 检查是否为子类
          // "isSubclassOf" => $reflection->isSubclassOf(),
          // ReflectionClass::isTrait — 返回了是否是 trait
          "isTrait" => $reflection->isTrait(),
          // ReflectionClass::isUserDefined — 检查是否由用户定义的
          "isUserDefined" => $reflection->isUserDefined(),
          // ReflectionClass::newInstance — 从指定的参数创建新类实例
          // "newInstance" => $reflection->newInstance(),
          // ReflectionClass::newInstanceArgs — 从给出的参数创建一个新的类实例
          // "newInstanceArgs" => $reflection->newInstanceArgs(),
          // ReflectionClass::newInstanceWithoutConstructor — 创建新的类实例而不调用它的构造函数
          // "newInstanceWithoutConstructor" => $reflection->newInstanceWithoutConstructor(),
          // ReflectionClass::setStaticPropertyValue — 设置静态属性的值
          // "setStaticPropertyValue" => $reflection->setStaticPropertyValue(),
          // ReflectionClass::__toString — 返回 ReflectionClass 对象字符串的表示形式
          // "__toString" => $reflection->__toString(),

        ]);

        $properties = $reflection->getProperties();
        $return = "<div style='padding-left: .5rem;'>"
          . "<details" . ($this->theme('details.open') === true || $depth === 0 ? ' open' : '') . ">"
          . "<summary>"
          . "<font style='" . $this->getElementStyles('summary') . "'>"
          . "<font style='" . $this->getElementStyles('object_type') . "'><b>object</b>(<i>$class</i>)[" . count($properties) . "] </font>"
          . "</font>"
          . "</summary>";
        foreach ($properties as $property) {
          // var_dump($property->getValue($value));
          // $return .= "\n";
          $return .= "<div style='padding-left: .5rem;'>";
          if ($property->isPublic()) {
            $return .= "<i>public</i> '<font style='" . $this->getElementStyles('object_key') . "'>" . $property->getName() . "</font>' => "
              . $this->print_type($property->getValue($value), $depth + 1);
          } elseif ($property->isProtected()) {
            $return .= "<i>protected</i> '<font style='" . $this->getElementStyles('object_key') . "'>" . $property->getName() . "</font>' => "
              . $this->print_type($property->getValue($value), $depth + 1);
          } elseif ($property->isPrivate()) {
            // var_dump($property);
            // var_dump($value);
            $return .= "<i>private</i> '<font style='" . $this->getElementStyles('object_key') . "'>" . $property->getName() . "</font>' => ";
            // . $this->print_type($property->getValue($value), $depth + 1);
          }
          $return .= "</div>";
        }
        unset($property);

        if ($reflection->getName() == 'Closure') {
          $return .= "<div style='padding-left: .5rem;'>";
          $return .= "<i>virtual</i> '<font style='" . $this->getElementStyles('object_key') . "'>closure</font>' '<font style='" . $this->getElementStyles('string') . "'>\$this->{closure}</font>' ";
          $return .= "</div>";
        }


        $return .= "</details>";
        $return .= '</div>';
        break;

      case 'array':
        if ($depth > $max_depth) return;

        // var_dump($value);
        $return .= "<div style='padding-left: .5rem;'>"
          . "<details" . ($this->theme('details.open') === true || $depth === 0 ? ' open' : '') . "><summary><font style='" . $this->getElementStyles('summary') . "'>"
          . "<font style='" . $this->getElementStyles('array_type') . "'><b>array</b> <i>(size=" . count($value) . ")</i> </font></font></summary>";
        if (count($value) == 0) {
          // var_dump($value);
          $return .= "<div style='padding-left: .5rem;'><i><font style='" . $this->getElementStyles('empty') . "'>empty</font></i></div>";
        } else if ($depth == $max_depth) {
          $return .=  "<div style='padding-left: .5rem;'>...</div>";
        } else {
          foreach ($value as $k => $v) {
            $return .= "<div style='padding-left: .5rem;'>";
            $return .=  (is_int($k) ? ("<font style='" . $this->getElementStyles('array_key') . "'>$k</font>") : ("'<font style='" . $this->getElementStyles('array_key') . "'>$k</font>'")) . " => " . $this->print_type($v, $depth + 1);
            $return .= '</div>';
          }
          unset($k, $v);
        }
        $return .= "</details>";
        $return .= '</div>';
        break;
      case 'string':
        $return .= "<small>string</small> <font style='" . $this->getElementStyles('string') . "'>'" . htmlspecialchars($value) . "'</font> <i>(length=" . strlen($value) . ")</i>";
        break;
      case 'integer':
        $return .= "<small>int</small> <font style='" . $this->getElementStyles('integer') . "'>$value</font>";
        break;
      case 'double':
        $return .= "<small>float</small> <font style='" . $this->getElementStyles('integer') . "'>$value</font>";
        break;
      case 'boolean':
        $return .= "<small>boolean</small> <font style='" . $this->getElementStyles('integer') . "'>" . ($value ? 'true' : 'false') . "</font>";
        break;
      case 'NULL':
        $return .= "<font style='" . $this->getElementStyles('null') . "'>null</font>";
        break;
      default:
        break;
    }
    // var_dump(gettype($value));
    // if(is_object($value))
    return preg_replace(['/\n\n/', '/\n<\/details>/', '/<summary>\n/'], ["\n", "</details>", "<summary>"], $return);
  }

  function getElementStyles($ele)
  {
    $theme = $this->theme('styles');
    $styles = $theme[$ele] ?? [];
    $return = '';
    foreach ($styles as $name => $value) {
      $return .= "$name: $value; ";
    }
    return $return;
  }

  function theme($key)
  {
    return config($this->alias . '.themes.options.' . config($this->alias . '.themes.default') . '.' . $key);
  }
}
