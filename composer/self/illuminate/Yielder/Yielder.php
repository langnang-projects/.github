<?php

namespace Illuminate\Yielder;

/**
 * yield关键字的作用是将当前函数变成一个生成器函数。
 * 在生成器函数内部，我们可以使用yield语句将一个值返回给调用者，并且生成器函数的执行状态会被保存。
 * 下次调用生成器函数时，会从上次的yield语句处继续执行。
 */
class Yielder {}
