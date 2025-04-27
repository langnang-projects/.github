<?php

namespace Modules\WebPage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebPage extends \App\Models\Content
{
    use HasFactory;

    protected $table = 'webpages';

    protected $relationshipKey = "webpage_id";
    protected $fillable = [];

    protected static function newFactory()
    {
        // return \Modules\WebPage\Database\factories\WebPageFactory::new();
    }
}
