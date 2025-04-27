<?php

namespace App\Traits\Model;


trait HasUser
{
    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_id');
    }
}