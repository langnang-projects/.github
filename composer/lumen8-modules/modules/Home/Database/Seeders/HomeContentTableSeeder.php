<?php

namespace Modules\Home\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Support\Module;
use Modules\Home\Models\HomeContent;

class HomeContentTableSeeder extends Seeder
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
        HomeContent::newFactory()
            ->times(50)
            ->create();

    }
}