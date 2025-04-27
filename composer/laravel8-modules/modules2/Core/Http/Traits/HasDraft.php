<?php

namespace App\Traits;

trait HasDraft
{
    public function hasDraftKeys()
    {
        return !(empty($this->draftKey) && empty($this->parentKey));
    }
    public static function drafts()
    {
    }
}