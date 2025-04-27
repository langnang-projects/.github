<?php

namespace App\Traits\Model;

trait HasPrimaryKeyPlural
{
    // 主键的复数形式，一般用于批量操作
    protected $primaryKeyPlural;

    public function setPrimaryKeyPlural($primaryKeyPlural = null)
    {
        return $this->$primaryKeyPlural = empty($primaryKeyPlural)
            ? \Str::of($this->getKeyName())->plural()
            : $primaryKeyPlural;
    }
    public function getPrimaryKeyPlural()
    {
        return $this->primaryKeyPlural;
    }

    public function __construct($attributes = [])
    {
        $this->setPrimaryKeyPlural();
    }
}