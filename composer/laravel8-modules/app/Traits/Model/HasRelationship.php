<?php

namespace App\Traits\Model;

trait HasRelationship
{

    public function metas()
    {
        return $this
            ->hasMany(\App\Models\Relationship::class, $this->relationshipKey, $this->primaryKey)
            ->leftJoin("metas", "relationships.meta_id", '=', "metas.id");
    }

    public function contents()
    {
        return $this
            ->hasMany(\App\Models\Relationship::class, $this->relationshipKey, $this->primaryKey)
            ->leftJoin("contents", "relationships.content_id", '=', "contents.id");
    }

    public function links()
    {
        // return $this->belongsToMany(\App\Models\Link::class, 'relationships', $this->relationshipKey, $this->primaryKey);
        return $this
            ->hasMany(\App\Models\Relationship::class, $this->relationshipKey, $this->primaryKey)
            ->leftJoin("links", "relationships.link_id", '=', "links.id");
    }

    public function relationships()
    {
        return $this->hasMany(\App\Models\Relationship::class, $this->relationshipKey, $this->primaryKey);
    }

    public function logs()
    {
    }


}
