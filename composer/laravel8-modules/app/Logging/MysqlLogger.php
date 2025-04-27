<?php
/**
 * 定义mysql日志channel
 */
namespace App\Logging;

class MysqlLogger
{

    public function __invoke(array $config)
    {
        // return tap(new \Monolog\Logger('mysql'), function ($logger) {
        // $logger->pushHandler(new MysqlLoggerHandler());
        // });
        $channel = $config['name'] ?? env('APP_ENV');
        $monolog = new \Monolog\Logger($channel);
        $monolog->pushHandler(new MysqlLoggerHandler());
        return $monolog;
    }
}

