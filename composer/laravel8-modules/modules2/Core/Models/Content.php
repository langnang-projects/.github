<?php

namespace Modules\Core\Models;


class Content extends \Modules\Core\Models\Core
{
    protected $table = "_contents";

    protected $primaryKey = 'cid';

    protected $fillable = [
        'title',
        'slug',
        'ico',
        'url',
        // 'description',
        'text',
        'type',
        'status',
        'user',
        'parent',
        'count',
        'order',
        'options',
        'suggestion',
        'release_at',
        'download_urls',
    ];
    protected $casts = [
        'release_at' => 'datetime',
        'options' => 'array',
        'download_urls' => 'array',
    ];
}
