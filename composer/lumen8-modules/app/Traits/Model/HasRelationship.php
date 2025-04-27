<?php

namespace App\Traits\Model;

trait HasRelationship
{

    public function metas()
    {
        return $this
            ->hasMany(\App\Models\Relationship::class, (empty($this->prefix) ? '' : $this->prefix . '_') . $this->primaryKey, $this->primaryKey)
            ->leftJoin($this->prefix . "_metas", "_relationships." . (empty($this->prefix) ? '' : $this->prefix . '_') . "mid", '=', $this->prefix . "_metas.mid");
    }

    public function contents()
    {
        return $this
            ->hasMany(\App\Models\Relationship::class, $this->prefix . '_' . $this->primaryKey, $this->primaryKey)
            ->leftJoin($this->prefix . "_contents", "_relationships." . $this->prefix . "_cid", '=', $this->prefix . "_contents.cid");
    }

    public function links()
    {
        return $this
            ->hasMany(\App\Models\Relationship::class, $this->prefix . '_' . $this->primaryKey, $this->primaryKey)
            ->leftJoin($this->prefix . "_links", "_relationships." . $this->prefix . "_lid", '=', $this->prefix . "_links.lid");
    }

    public function relationships()
    {
        return $this->hasMany(\App\Models\Relationship::class, $this->prefix . '_' . $this->primaryKey, $this->primaryKey);
    }

    public function logs()
    {
    }
}
