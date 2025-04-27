<?php

namespace App\Models;

use \App\Illuminate\Database\Eloquent\Model;

class Rule extends Model
{

    /**
     * 与模型关联的数据表.
     *
     * @var string
     */
    protected $table = "rules";

    protected $fillable = [
        'timestamp'
    ];
}