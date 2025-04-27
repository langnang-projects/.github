<?php

namespace Modules\WebHunt\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebHunt extends Model
{
    use HasFactory;
    protected $table = "webhunts";
    protected $fillable = [
        "slug",
        "ico",
        "title",
        "text",
        "type",
        "status",
    ];

    protected $casts = [
        "text" => "array",
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'release_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    protected static function newFactory()
    {
        // return \Modules\WebHunt\Database\factories\WebHuntFactory::new();
    }

}
