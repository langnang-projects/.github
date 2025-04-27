<?php

namespace App\Traits\Model;

/**
 * 草稿
 */
trait HasStatusDraft
{
    /**
     * 草稿
     */
    public function draft()
    {
        return $this->hasOne(static::class, $this->parentKey, $this->primaryKey)->with($this->fieldColumns ?? [])->where([['status', 'draft']]);
    }

    /**
     * 草稿列表，草稿记录
     */
    public function drafts()
    {
        return $this->hasMany(static::class, $this->parentKey, $this->primaryKey)->with($this->fieldColumns ?? [])->where([['status', 'draft']]);
    }

    /**
     * 检测是否存在草稿记录
     */
    public function draft_exists()
    {
    }
}