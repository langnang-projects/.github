<?php

namespace Modules\Spider\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpiderContentModel extends \App\Models\Content
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Spider\Database\factories\SpiderContentModelFactory::new();
    }

    public function toArray()
    {
        $return = parent::toArray();

        $configs = $return['ini']['spider'];

        $configs['fields'] = array_map(function ($name, $index) use ($configs) {
            return [
                'name' => $name,
                'selector' => $configs['fields.selector'][$index],
                'required' => $configs['fields.required'][$index],
                'repeated' => $configs['fields.repeated'][$index],
                'default' => $configs['fields.default'][$index],
                'filters' => $configs['fields.filter'][$index] ?? '',
            ];
        }, $configs['fields.name'], array_keys($configs['fields.name']));

        unset($configs['fields.name']);
        unset($configs['fields.selector']);
        unset($configs['fields.required']);
        unset($configs['fields.repeated']);
        unset($configs['fields.default']);
        unset($configs['fields.filter']);

        $return['ini']['spider'] = $configs;
        return $return;

    }

}
