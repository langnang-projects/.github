<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Models\Relationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;


class Content extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    use \App\Traits\Model\HasFamily,
        \App\Traits\Model\HasRelationship;

    public $table = '_contents';
    public $primaryKey = "cid";
    public $parentColumn = 'parent';
    // 关联字段表的方法
    public $fieldColumns = ['fields'];
    public $uniqueIndex = "slug";

    protected $fillable = [
        'title',
        'slug',
        'ico',
        'url',
        // 'description',
        'text',
        'type',
        'status',
        'user',
        'parent',
        'count',
        'order',
        'options',
        'suggestion',
        'release_at',
        'download_urls',
    ];
    protected $casts = [
        'release_at' => 'datetime',
        'options' => 'array',
        'download_urls' => 'array',
    ];

    static $fields = [
        'relationships' => \App\Modules\Models\Relationship::class,
        'draft' => self::class,
        // 'comments'=>
        // 'fields'=>
    ];
    // static $fields = ['fields'];

    public function fields($name = "Field")
    {
        $FieldModel = str_replace("Content", $name, static::class);
        if (!class_exists($FieldModel))
            $FieldModel = \App\Models\Field::class;
        return $this->hasMany($FieldModel, $this->primaryKey, $this->primaryKey);
    }

    public function comments()
    {
        $CommentModel = str_replace("Content", "Comment", static::class);
        if (!class_exists($CommentModel))
            $CommentModel = \App\Models\Comment::class;
        return $this->hasMany($CommentModel, $this->primaryKey, $this->primaryKey);
    }

    public function collection(Collection $rows)
    {
        $rows = parent::collection($rows);
        if (request()->filled('mids')) {
            $mids = explode(',', request()->input('mids'));
            // dump($mids);
            foreach ($mids as $mid) {
                $this->relationships()->insert(array_map(function ($row) use ($mid) {
                    return [
                        $this->prefix . '_cid' => $row->cid,
                        $this->prefix . '_mid' => $mid,
                    ];
                }, (array) $rows));
            }
        }
    }
    public function toArray()
    {
        $return = parent::toArray();

        $return['ini'] = $this->parse_text_ini($return['text']);

        return $return;
    }
    public function parse_text_ini($text)
    {
        $text_config = substr($text, strripos($text, "```ini"));
        $ini = parse_ini_string($text_config, true, INI_SCANNER_RAW);
        return $ini;
    }
}