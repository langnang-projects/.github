<?php

namespace Illuminate\FileSystem;

require_once __DIR__ . '/../../core/Illuminate.php';

/**
 * @var string $name
 * @var string $type
 * @var string $extension
 * @var string $content
 * @var string $path
 * @var string $dirname
 * @var int $created_time
 * @var int $updated_time
 * @var int $visited_time
 * @var string $created_at
 * @var string $updated_at
 * @var string $visited_at
 * 
 * 
 * @method mixed _init
 * 
 * @method mixed read
 * @method mixed write
 */
class File
{
  /**
   * Summary of filepath
   * @var string
   */
  public $filepath;
  /**
   * @var string
   */
  public $dirname;
  /**
   * 
   * @var string
   */
  public $basename;
  /**
   * 
   * @var string
   */
  public $filename;
  /**
   * 
   * @var string
   */
  public $extension;
  /**
   * Summary of name
   * @var string
   */
  public $name;
  /**
   * Summary of name
   * @var string
   */
  public $content;
  /**
   * file size
   * @var string
   */
  public $size;
  /**
   * file type
   * @var string
   */
  public $filetype;
  /**
   * inode change time of file
   */
  public $created_time;
  public $created_at;
  /**
   * file modification time
   */
  public $updated_time;
  public $updated_at;
  /**
   * last access time of file
   */
  public $visited_time;
  public $visited_at;
  /**
   * file permissions
   */
  public $permissions;
  /**
   * the md5 hash of a given file
   */
  public $md5;
  /**
   * file group
   */
  public $group;
  /**
   * file inode
   */
  public $inode;
  /**
   * file owner
   */
  public $owner;

  /**
   * 
   */
  protected $driver;
  function _init($filepath)
  {
    $this->filepath = $filepath;

    if (!is_file($filepath)) {
      $this->error_message = "path not file.";
      return $this;
    }
    if (!file_exists($filepath)) {
      $this->error_message = "file not exist.";
      return $this;
    }
    ;
    foreach (pathinfo($filepath) as $k => $v) {
      $this->{$k} = $v;
    }
    $this->size = filesize($filepath);
    $this->filetype = filetype($filepath);
    $this->group = filegroup($filepath);
    $this->inode = fileinode($filepath);
    $this->created_time = filectime($filepath);
    $this->created_at = date('Y-m-d h:i:s', $this->created_time);
    $this->updated_time = filemtime($filepath);
    $this->updated_at = date('Y-m-d h:i:s', $this->updated_time);
    $this->visited_time = fileatime($filepath);
    $this->visited_at = date('Y-m-d h:i:s', $this->visited_time);
    $this->owner = fileowner($filepath);
    $this->permissions = fileperms($filepath);
    $this->md5 = md5_file($filepath);
    return $this;
  }
  function of($filepath)
  {
    $this->_init($filepath);
    $this->setDriver();
    return $this->driver ?: $this;
  }
  function setDriver($extension = null)
  {
    $extension = $extension ?: $this->extension;
    if (empty($extension))
      return;
    $driverClass = config('file.extensions.' . $extension);
    if (empty($driverClass))
      return;
    $driver = new $driverClass($this);
    $this->driver = $driver;
  }
  function read($size = null)
  {
    $file = fopen($this->filepath, 'r');
    $this->content = fread($file, $size ?: $this->size);
    fclose($file);
    return $this->content;
  }
  function write()
  {
  }
  function prepend()
  {
  }
  function append()
  {
  }
  function download()
  {
  }
  function upload()
  {
  }
  function zip()
  {
  }
  function unzip()
  {
  }
}
