<?php

namespace App\Traits\Model;

trait HasPrefix
{
    protected $prefix = "";

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function setPrefix($prefix = null)
    {
        $this->prefix = $prefix ?? \Config::get(strtolower(\Module::current()) . '.db_prefix');
    }

    public function getTable()
    {
        // 没有定义表前缀
        if (empty($this->prefix))
            return $this->table;
        // 表前缀与当前表名前部分一致
        if (substr($this->table, 0, strlen($this->prefix)) === $this->prefix)
            return $this->table;
        // 默认
        return $this->prefix . $this->table;
    }

    // public function __construct(array $attributes = [])
    // {
    //     $this->setPrefix();
    // }

}