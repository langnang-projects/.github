<?php

namespace Modules\Market\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MarketProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'author',
        'type',
        'path',
    ];

    protected static function newFactory()
    {
        return \Modules\Market\Database\factories\MarketProjectFactory::new();
    }
}
