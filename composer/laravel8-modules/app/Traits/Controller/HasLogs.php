<?php

namespace App\Traits\Controller;

trait HasLogs
{

    protected $logs = [];

    public function getLogs()
    {
        return $this->logs;
    }

    public function prependLogs(...$logs)
    {
        array_unshift($this->logs, ...$logs);
    }
    public function appendLogs(...$logs)
    {
        array_push($this->logs, ...$logs);
    }
}
