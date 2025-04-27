<?php

namespace Modules\CheatSheet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheatSheet extends \App\Models\Content
{
    use HasFactory;
    protected $table = "cheatsheets";

    // protected $primaryKey = 'cid';
    protected $relationshipKey = "cheatsheet_id";
    // protected $fillable = [];

    protected static function newFactory()
    {
        // return \Modules\CheatSheet\Database\factories\CheatSheetFactory::new();
    }
}
