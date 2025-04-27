<?php

namespace Modules\Home\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeMeta extends Model
{
    use HasFactory;
    protected $table = "_metas";
    protected $primaryKey = 'mid';
    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Home\Database\factories\HomeMetaFactory::new();
    }
}