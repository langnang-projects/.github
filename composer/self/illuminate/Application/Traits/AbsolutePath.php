<?php

namespace Illuminate\Application\Traits;

trait AbsolutePath
{
  public $appPath;
  public $basePath;
  public $databasePath;
  function path($path = '')
  {
    $appPath = $this->appPath ?: $this->basePath . DIRECTORY_SEPARATOR . 'app';

    return $appPath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
  }
  function setBasePath($basePath)
  {
    $this->basePath = rtrim($basePath, '\/');
    return $this;
  }
  function resourcePath($path = '')
  {
    return $this->basePath . DIRECTORY_SEPARATOR . 'resources' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
  }
  function basePath($path = '')
  {
    return $this->basePath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
  }

  function databasePath($path = '')
  {
    return ($this->databasePath ?: $this->basePath . DIRECTORY_SEPARATOR . 'database') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
  }
  function publicPath()
  {
    return $this->basePath . DIRECTORY_SEPARATOR . 'public';
  }
  function langPath()
  {
    if ($this->langPath) {
      return $this->langPath;
    }

    if (is_dir($path = $this->resourcePath() . DIRECTORY_SEPARATOR . 'lang')) {
      return $path;
    }

    return $this->basePath() . DIRECTORY_SEPARATOR . 'lang';
  }
  function configPath($path = '')
  {
    return $this->basePath . DIRECTORY_SEPARATOR . 'config' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
  }
  function storagePath($path = '')
  {
    return $this->basePath . DIRECTORY_SEPARATOR . 'storage' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
  }
  function logPath($path = '')
  {
    return $this->basePath . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'logs' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
  }
}
