<?php

namespace App\Traits\Model;

/**
 * Summary of HasFamily
 * @method mixed parent()
 * @method mixed children()
 * @method mixed parents()
 * @method mixed child()
 */
trait HasFamily
{
    // protected $prevKey;
    // protected $nextKey;

    // 弟类
    public function next()
    {
    }
    // 兄类
    public function prev()
    {
    }
    // 同级类
    public function sibling()
    {
    }
    /**
     * 父类
     */
    public function parent()
    {
        return $this->hasOne(static::class, $this->primaryKey, $this->parentKey, );
    }

    public function parent_exists()
    {
    }
    public function parents()
    {
        return $this->hasOne(static::class, $this->primaryKey, $this->parentKey, )->with('parent');
    }
    public function root()
    {
        return $this->hasOne(static::class, $this->primaryKey, $this->parentKey, )->with('root');
    }
    /**
     * Retrieve the root parent of the current category.
     * The root parent of a category that has no parent is that category itself.
     *
     */
    public function getRoot()
    {
        $bubble_keys = [$this[$this->getKeyName()]];
        // $this->bubbule_keys = $this->active_keys ?? [$this[$this->getKeyName()]];
        if ($this->root) {
            if ($this->root->root) {
                $this->root = $this->root->getRoot();
                // dump($this->root->active_keys);
            }
            // array_unshift($bubble_keys);
            $this->root->bubble_keys = array_merge($this->root->bubble_keys ?? [$this->root[$this->getKeyName()]], $bubble_keys);
            return $this->root;
        }
        $this->bubble_keys = array_merge($this->bubble_keys ?? [], $bubble_keys);
        return $this;
        // if ($this->root && $this->root->root) {
        //   return $this->getRoot();
        // }
        // return $this->root;
    }
    /**
     * 子集
     */
    public function children()
    {
        return $this->hasMany(static::class, $this->parentKey, $this->primaryKey);
    }
}