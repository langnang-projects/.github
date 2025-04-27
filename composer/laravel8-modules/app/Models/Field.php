<?php

namespace App\Models;

class Field extends \App\Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    /**
     * 与模型关联的数据表.
     *
     * @var string
     */
    protected $table = "fields";
    /**
     * 模型的属性默认值。
     *
     * @var array
     */
    protected $attributes = [];
    // protected $primaryKey = 'id';

    protected $fillable = [
        "id",
        "name",
        "type",
        "float_value",
        "int_value",
        "str_value",
        "text_value",
        "object_value",
    ];

    protected $casts = [
        'object_value' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'release_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function content()
    {
        return $this->belongsTo(\App\Models\Content::class, 'cid', 'cid');
    }

    public function toArray()
    {
        $return = parent::toArray();
        switch ($return['type']) {
            case "float":
                $return['value'] = $return['float_value'];
                break;
            case "int":
                $return['value'] = $return['int_value'];
                break;
            case "str":
                $return['value'] = $return['str_value'];
                break;
            case "text":
                $return['value'] = $return['text_value'];
                break;
            case "object":
                $return['value'] = $return['object_value'];
                // $return['value'] = json_decode($return['object_value'], true);
                break;
        }
        return $return;
    }
}