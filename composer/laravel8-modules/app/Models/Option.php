<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Option extends \App\Illuminate\Database\Eloquent\Model
{
    /**
     * 与模型关联的数据表.
     *
     * @var string
     */
    public $table = 'options';
    /**
     * 指明模型的 ID 不是自增。
     *
     * @var bool
     */
    public $incrementing = false;
    protected $hidden = [
        'user_id',
        'id',
    ];
    protected $fillable = [
        'name',
        'user_id',
        'type',
        'value',
        'created_at',
        'updated_at',
        'release_at',
        'deleted_at'
    ];

    /**
     * 模型的属性默认值。
     *
     * @var array
     */
    protected $attributes = [];

    public function toArray()
    {
        $return = parent::{__FUNCTION__}();
        // dump(__FUNCTION__);
        if (empty($return['type'])) {

        } else if (in_array($return['type'], ['json', 'array', 'object'], )) {
            $return['value'] = unserialize($this->value);
        }
        return $return;
    }
}