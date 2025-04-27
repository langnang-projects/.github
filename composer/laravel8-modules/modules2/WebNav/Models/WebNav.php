<?php

namespace Modules\WebNav\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebNav extends Model
{
    use HasFactory;
    protected $table = "webnavs";
    protected $relationshipKey = "webnav_id";

    protected $fillable = [
    ];

    protected static function newFactory()
    {
        return \Modules\WebNav\Database\factories\WebNavFactory::new();
    }
}
