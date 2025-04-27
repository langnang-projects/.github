<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\TraitsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;


class Meta extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    public $table = '_metas';
    public $primaryKey = 'mid';
    public $parentColumn = 'parent';
    public $uniqueIndex = "slug";
    protected $fillable = [
        'name',
        'slug',
        'ico',
        'description',
        'type',
        'status',
        'parent',
        'count',
        'order',
        'release_at',
    ];

    public function toArray()
    {
        $result = parent::toArray();
        //        if (!empty($this->contents)) {
        //            $result['contents'] = $this->contents->toArray();
        //        }
        return $result;
    }

    public function collection(Collection $rows)
    {
        $rows = parent::collection($rows);
        if (request()->filled('cids')) {
            $cids = explode(',', request()->input('cids'));
            // dump($mids);
            foreach ($cids as $cid) {
                $this->relationships()->insert(array_map(function ($row) use ($cid) {
                    return [
                        $this->prefix . '_mid' => $row->mid,
                        $this->prefix . '_cid' => $cid,
                    ];
                }, (array) $rows));
            }
        }
    }
}