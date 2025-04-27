<?php

namespace App\Models;

class Comment extends \App\Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    /**
     * 与模型关联的数据表.
     *
     * @var string
     */
    protected $table = "comments";

    // protected $primaryKey = 'coid';
    /**
     * 模型的属性默认值。
     *
     * @var array
     */
    protected $attributes = [];
    protected $fillable = [];

}