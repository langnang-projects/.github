<?php

namespace Modules\WebHunt\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebHuntGroup extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        // return \Modules\WebHunt\Database\factories\WebHuntGroupFactory::new();
    }
}
