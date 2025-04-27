<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Link extends Model
{
    use HasFactory;
    public $table = '_links';
    public $primaryKey = "lid";

    public function rules($name = "Rule")
    {
        $RuleModel = str_replace("Link", $name, static::class);
        if (!class_exists($RuleModel))
            $RuleModel = \App\Models\Rule::class;
        return $this->hasMany($RuleModel, $this->primaryKey, $this->primaryKey);
    }
}
