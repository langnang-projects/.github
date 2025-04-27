<?php

namespace App\Models;
use Symfony\Component\DependencyInjection\Dumper\YamlDumper;
use Symfony\Component\Yaml\Yaml;


class Content extends \App\Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    use \App\Traits\Model\HasFamily;
    use \App\Traits\Model\HasRelationship;
    use \App\Traits\Model\HasUser;
    /**
     * 与模型关联的数据表.
     *
     * @var string
     */
    protected $table = "contents";
    /**
     * 模型的属性默认值。
     *
     * @var array
     */
    protected $attributes = [];
    // protected $primaryKey = 'cid';
    protected $relationshipKey = "content_id";
    protected $fillable = [
        'title',
        'slug',
        'ico',
        'description',
        'text',
        'type',
        'status',
        'user_id',
        'template',
        'views',
        'parent',
        'count',
        'order',
        'created_at',
        'updated_at',
        'release_at',
        'deleted_at',
    ];
    protected $appends = [
        'config'
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'release_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    static $fields = [];
    /**
     * Summary of latest
     * @param mixed $perPage
     * @param mixed $columns
     * @param mixed $pageName
     * @param mixed $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function latest_updated($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return self::latest("updated_at")->paginate($perPage, $columns, $pageName, $page);
    }
    public static function hottest($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return self::orderBy("views", "desc")->paginate($perPage, $columns, $pageName, $page);
    }

    public static function toplist($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return self::paginate($perPage, $columns, $pageName, $page);
    }
    public static function recommend($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return self::paginate($perPage, $columns, $pageName, $page);
    }
    public static function collection($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return self::paginate($perPage, $columns, $pageName, $page);
    }
    public function metas()
    {
        return $this
            ->hasMany(\App\Models\Relationship::class, 'meta_id', 'meta_id')
            ->leftJoin("metas", "relationships.meta_id", '=', "metas.id");
    }

    public function links()
    {
        return $this
            ->hasMany(\App\Models\Relationship::class, 'link_id', 'link_id')
            ->leftJoin("links", "relationships.link_id", '=', "links.id");
    }

    public function relationships()
    {
        return $this->hasMany(\App\Models\Relationship::class, $this->relationshipKey, $this->primaryKey);
    }
    public function belongsToMeta()
    {
        return $this->belongsToMany(\App\Models\Meta::class, \App\Models\Relationship::class, 'content_id', 'meta_id');
    }
    public function fields()
    {
        return $this->hasMany(\App\Models\Field::class, $this->primaryKey, $this->primaryKey);
    }
    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class, $this->primaryKey, $this->primaryKey);
    }
    public function getConfigAttribute()
    {
        $return = [];
        $text = trim("
        
----
layout: master
theme: default
----


");
        if (\Str::startsWith($text, '----')) {
            // var_dump($text);
            // var_dump(\Str::between($text, '----', '----'));
            // var_dump(Yaml::parse(\Str::between($text, '----', '----')));

            $return = Yaml::parse(\Str::between($text, '----', '----'));
        }
        return $return;

    }
    public function toArray()
    {
        $return = parent::toArray();

        foreach ($return['fields'] ?? [] as $index => $field) {
            $return['fields'][$field['name']] = (new \App\Models\Field($field))->toArray();
            unset($return['fields'][$index]);
        }
        return $return;
    }
}