<?php

namespace App\Traits\Model;

trait HasPrimaryKeyPlural
{
    // 主键的复数形式，一般用于批量操作
    protected $primaryKeyPlural;

    public function setPrimaryKeyPlural($primaryKeyPlural = null)
    {
        var_dump(__CLASS__);
        var_dump($this->getKeyName());
        var_dump(empty($primaryKeyPlural)
            ? \Str::of($this->getKeyName())->plural()->__toString()
            : $primaryKeyPlural);
        return $this->$primaryKeyPlural = empty($primaryKeyPlural)
            ? \Str::of($this->getKeyName())->plural()->__toString()
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