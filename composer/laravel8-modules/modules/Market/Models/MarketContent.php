<?php

namespace Modules\Market\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MarketContent extends Model
{
    use HasFactory;

    protected $fillable = [];


    protected $casts = [
        'text' => 'array',
    ];

    protected static function newFactory()
    {
        return \Modules\Market\Database\factories\MarketContentFactory::new();
    }
}
