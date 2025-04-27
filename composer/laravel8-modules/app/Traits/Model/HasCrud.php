<?php

namespace App\Traits\Model;


trait HasCrud
{
    public static function InsertItem(\Request $request)
    {
    }

    public static function InsertList(\Request $request)
    {
    }
    public static function selectItem(\Request $request)
    {
        return self::first();
    }

    public static function selectList(\Request $request)
    {
    }

    public static function selectPage(\Request $request)
    {
    }
}