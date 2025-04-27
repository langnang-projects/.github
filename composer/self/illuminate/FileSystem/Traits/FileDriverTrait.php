<?php

namespace Illuminate\File\Traits;

trait FileDriverTrait
{
  public $file;
  public function __construct(\Illuminate\File\File $file = null)
  {
    $this->file = $file;
  }
  public function __call($name, $arguments)
  {
    if (!method_exists($this, $name) && method_exists($this->file, $name)) {
      return $this->file->{$name}(...$arguments);
    }
  }
}
