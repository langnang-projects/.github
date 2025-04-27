<?php

namespace App\Models;

class File extends \App\Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    /**
     * 与模型关联的数据表.
     *
     * @var string
     */
    protected $table = "files";
    /**
     * 模型的属性默认值。
     *
     * @var array
     */
    protected $attributes = [];
    // protected $primaryKey = 'coid';

    protected $fillable = [
        'slug',
        'name',
        'extension',
        'path',
        'type',
        'status',
        'user_id',
        'template',
        'views',
        'parent',
        'count',
        'order',
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
    ];
}