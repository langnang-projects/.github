<?php

namespace App\Models;

class Relationship extends \App\Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    /**
     * 与模型关联的数据表.
     *
     * @var string
     */
    protected $table = "relationships";
    /**
     * 指示模型是否主动维护时间戳。
     *
     * @var bool
     */
    public $timestamps = false;
    protected $fillable = [];

    protected $casts = [];

}