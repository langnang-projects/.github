<?php

namespace Illuminate\Traitor;

/**
 * Trait 是为类似 PHP 的单继承语言而准备的一种代码复用机制。
 * Trait 为了减少单继承语言的限制，使开发人员能够自由地在不同层次结构内独立的类中复用 method。
 * Trait 和 Class 组合的语义定义了一种减少复杂性的方式，避免传统多继承和 Mixin 类相关典型问题。
 * 
 * Trait 和 Class 相似，但仅仅旨在用细粒度和一致的方式来组合功能。
 * 无法通过 trait 自身来实例化。它为传统继承增加了水平特性的组合；也就是说，应用的几个 Class 之间不需要继承。
 * 
 * @name
 * @description
 */
class Traitor
{
  /**
   * @param  string  $trait
   * @return TraitUseAdder
   */
  public static function addTrait($trait)
  {
    $instance = new TraitUseAdder();

    return $instance->addTraits([$trait]);
  }

  /**
   * @param  array  $traits
   * @return TraitUseAdder
   */
  public static function addTraits($traits)
  {
    $instance = new TraitUseAdder();

    return $instance->addTraits($traits);
  }

  /**
   * Check if provided class uses a specific trait.
   *
   * @param  string  $className
   * @param  string  $traitName
   * @return bool
   */
  public static function alreadyUses($className, $traitName)
  {
    return in_array($traitName, class_uses($className));
  }
}
