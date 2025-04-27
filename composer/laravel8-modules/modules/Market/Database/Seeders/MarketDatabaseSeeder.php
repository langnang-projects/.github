<?php

namespace Modules\Market\Database\Seeders;

use App\Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class MarketDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();

        // $this->call("OthersTableSeeder");
        $this->call([
            // \Modules\Market\Database\Seeders\MarketContentsTableSeeder::class,
        ]);
    }
}
