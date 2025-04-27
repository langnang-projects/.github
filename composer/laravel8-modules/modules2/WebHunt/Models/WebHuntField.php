<?php

namespace Modules\WebHunt\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebHuntField extends Model
{
    use HasFactory;
    protected $table = "webhunt_fields";

    protected $fillable = [];

    protected static function newFactory()
    {
        // return \Modules\WebHunt\Database\factories\WebHuntFieldFactory::new();
    }
}
