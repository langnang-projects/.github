<?php

namespace Illuminate\Logger;

class Logger extends \Core\Illuminate
{

  use Traits\ParsesLogConfiguration;
  /**
   * The application instance.
   *
   * @var \Illuminate\Contracts\Foundation\Application
   */
  protected $app;
  /**
   * The array of resolved channels.
   *
   * @var array
   */
  protected $channels = [];

  /**
   * The standard date format to use when writing logs.
   *
   * @var string
   */
  protected $dateFormat = 'Y-m-d H:i:s';

  /**
   * Get a log channel instance.
   *
   * @param  string|null  $channel
   * @return \Psr\Log\LoggerInterface
   */
  public function channel($channel = null)
  {
    return $this->driver($channel);
  }

  /**
   * Get a log driver instance.
   *
   * @param  string|null  $driver
   * @return \Psr\Log\LoggerInterface
   */
  public function driver($driver = null)
  {
    return $this->get($this->parseDriver($driver));
  }

  /**
   * Log an emergency message to the logs.
   *
   * @param  string  $message
   * @param  array  $context
   * @return void
   */
  public function emergency($message, array $context = [])
  {
    $this->writeLog(__FUNCTION__, $message, $context);
  }

  /**
   * Log an alert message to the logs.
   *
   * @param  string  $message
   * @param  array  $context
   * @return void
   */
  public function alert($message, array $context = [])
  {
    $this->writeLog(__FUNCTION__, $message, $context);
  }

  /**
   * Log a critical message to the logs.
   *
   * @param  string  $message
   * @param  array  $context
   * @return void
   */
  public function critical($message, array $context = [])
  {
    $this->writeLog(__FUNCTION__, $message, $context);
  }

  /**
   * Log an error message to the logs.
   *
   * @param  string  $message
   * @param  array  $context
   * @return void
   */
  public function error($message, array $context = [])
  {
    $this->writeLog(__FUNCTION__, $message, $context);
  }

  /**
   * Log a warning message to the logs.
   *
   * @param  string  $message
   * @param  array  $context
   * @return void
   */
  public function warning($message, array $context = [])
  {
    $this->writeLog(__FUNCTION__, $message, $context);
  }

  /**
   * Log a notice to the logs.
   *
   * @param  string  $message
   * @param  array  $context
   * @return void
   */
  public function notice($message, array $context = [])
  {
    $this->writeLog(__FUNCTION__, $message, $context);
  }

  /**
   * Log an informational message to the logs.
   *
   * @param  string  $message
   * @param  array  $context
   * @return void
   */
  public function info($message, array $context = [])
  {
    $this->writeLog(__FUNCTION__, $message, $context);
  }

  /**
   * Log a debug message to the logs.
   *
   * @param  string  $message
   * @param  array  $context
   * @return void
   */
  public function debug($message, array $context = [])
  {
    $this->writeLog(__FUNCTION__, $message, $context);
  }

  /**
   * Log a message to the logs.
   *
   * @param  string  $level
   * @param  string  $message
   * @param  array  $context
   * @return void
   */
  public function log($level, $message, array $context = [])
  {
    $this->writeLog($level, $message, $context);
  }

  /**
   * Dynamically pass log calls into the writer.
   *
   * @param  string  $level
   * @param  string  $message
   * @param  array  $context
   * @return void
   */
  public function write($level, $message, array $context = [])
  {
    $this->writeLog($level, $message, $context);
  }

  /**
   * Write a message to the log.
   *
   * @param  string  $level
   * @param  string  $message
   * @param  array  $context
   * @return void
   */
  protected function writeLog($level, $message, $context)
  {
    $this->logger->{$level}(
      $message = $this->formatMessage($message),
      $context = array_merge($this->context, $context)
    );

    $this->fireLogEvent($level, $message, $context);
  }
}
