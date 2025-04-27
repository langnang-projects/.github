<?php

namespace Modules\Home\Models;


class HomeContent extends \App\Support\Database\Eloquent\Model
{
    protected $table = "_contents";

    protected $primaryKey = 'cid';

    protected $fillable = [
        'title',
        'slug',
        'ico',
        // 'description',
        'text',
        'type',
        'status',
        'user',
        'parent',
        'count',
        'order',
        'fields',
        'created_at',
        'updated_at',
        'release_at',
        'deleted_at',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'release_at' => 'datetime',
        'deleted_at' => 'datetime',
        'fields' => 'array',
    ];

    protected static function newFactory()
    {
        return \Modules\Home\Database\factories\HomeContentFactory::new();
    }
}