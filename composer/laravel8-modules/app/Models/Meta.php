<?php

namespace App\Models;
/**
 * 通用标识类模型
 * 
 */
class Meta extends \App\Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    use \App\Traits\Model\HasFamily;
    use \App\Traits\Model\HasRelationship;
    /**
     * 与模型关联的数据表.
     *
     * @var string
     */
    protected $table = "metas";
    /**
     * 模型的属性默认值。
     *
     * @var array
     */
    protected $attributes = [];
    // protected $primaryKey = 'mid';

    protected $relationshipKey = "meta_id";

    protected $fillable = [
        'name',
        'slug',
        'ico',
        'description',
        'type',
        'status',
        'parent',
        'count',
        'order',
        'user_id',
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