<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Field extends Model
{
    use HasFactory;
    public $table = '_fields';
    public $primaryKey = "id";
    public $parentColumn = 'parent';

    protected $casts = [
        "object_value" => "array",
    ];
    protected $fillable = [
        "cid",
        "name",
        "title",
        'slug',
        'ico',
        'description',
        'play_url',
        'next',
        'prev',
        "type",
        "str_value",
        "int_value",
        "float_value",
        "object_value",
        'parent',
    ];

    function toArray()
    {
        $return = parent::toArray();
        if (isset($return['value'])) {
            $return['value'] = $return[$return['type'] . '_value'];
            unset($return['str_value']);
            unset($return['int_value']);
            unset($return['float_value']);
            unset($return['object_value']);
        }
        return $return;
    }
}
