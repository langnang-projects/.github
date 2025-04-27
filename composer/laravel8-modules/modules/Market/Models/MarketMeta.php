<?php

namespace Modules\Market\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MarketMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'ico',
        'slug',
        'description',
        'type',
        'status',
        'select_package_list_api',
        'select_package_item_api',
        'select_version_list_api',
        'select_version_item_api',
    ];

    protected static function newFactory()
    {
        return \Modules\Market\Database\factories\MarketMetaFactory::new();
    }
}