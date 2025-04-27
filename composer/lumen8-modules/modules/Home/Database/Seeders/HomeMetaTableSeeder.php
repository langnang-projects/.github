<?php

namespace Modules\Home\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Home\Models\HomeMeta;

class HomeMetaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        HomeMeta::upsert([
            [
                "name" => "faker",
                'slug' => "branch_faker",
                "type" => "branch"
            ],
            [
                "name" => "mock",
                'slug' => "branch_mock",
                "type" => "branch"
            ]
        ], ['slug']);
        Model::reguard();
    }
}