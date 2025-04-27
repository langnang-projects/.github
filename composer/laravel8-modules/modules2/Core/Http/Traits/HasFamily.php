<?php

namespace App\Traits;

trait HasFamily
{

    public function hasFamilyKeys()
    {
        return !(empty($this->childKey) && empty($this->parentKey));
    }
    public function children()
    {
        if (!$this->hasFamilyKeys()) return;
    }
    public function child()
    {
        if (!$this->hasFamilyKeys()) return;
    }
    public function parents()
    {
        if (!$this->hasFamilyKeys()) return;
    }
    public function parent()
    {
        if (!$this->hasFamilyKeys()) return;
    }
}