<?php

namespace Modules\Application\Database\Seeders;

use App\Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ApplicationDatabaseSeeder extends Seeder
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
    }
}
