<?php

namespace App\Support;

use App\Support\Module;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * @class \App\Support\Model
 * @extends \Illuminate\Database\Eloquent\Model
 * @use \Illuminate\Database\Eloquent\Factories\HasFactory
 * @use \Illuminate\Database\Eloquent\Concerns\HasAttributes
 * @use \Illuminate\Database\Eloquent\Concerns\HasEvents
 * @use \Illuminate\Database\Eloquent\Concerns\HasGlobalScopes
 * @use \Illuminate\Database\Eloquent\Concerns\HasRelationships
 * @use \Illuminate\Database\Eloquent\Concerns\HasTimestamps
 * @use \Illuminate\Database\Eloquent\Concerns\HidesAttributes
 * @use \Illuminate\Database\Eloquent\Concerns\GuardsAttributes
 * @var string $prefix
 * @method string getTable()
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;
    use \App\Traits\Model\HasPrefix,
        // \App\Traits\Model\HasPrimaryKeyPlural,
        \App\Traits\Model\HasFamily;

    protected $dates = [
        'created_at',
        'updated_at',
        'release_at',
        'deleted_at'
    ];
    //
    protected $fillable = [
        'created_at',
        'updated_at',
        'release_at',
        'deleted_at'
    ];
    //
    protected $cast = [];
    //
    protected static $unguarded = false;

    protected $primaryKeyPlural;

    /**
     * 为数组 / JSON 序列化准备日期。
     *
     * @param \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
    }

    public function isFilledPrimaryKey()
    {
    }
}