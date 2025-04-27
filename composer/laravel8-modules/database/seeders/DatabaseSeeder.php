<?php

namespace Database\Seeders;

use App\Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            OptionTableSeeder::class,
        ]);



        $this->call(array_merge([
            ModuleDatabaseSeeder::class,
        ], array_map(function ($moduleName) {
            return "\Modules\\" . $moduleName . "\Database\Seeders\\" . $moduleName . "DatabaseSeeder";
        }, array_keys(\Module::all()))));



        // \App\Models\User::factory(1)->insert();
        \App\Models\Meta::factory(100)->create();
        \App\Models\Content::factory(100)->create();
        // \App\Models\Field::factory(1000)->create();
        // \App\Models\Comment::factory(100)->create();
        // \App\Models\Link::factory(10)->create();

        $this->upsert('links', \App\Models\Link::class, ['slug']);


        // \App\Models\link::upsert($this->getInitializaions('links'), ['slug'], ['slug', 'title', 'url', 'ico', 'description', 'keywords', 'type', 'status']);

        \App\Models\Relationship::factory(100)->create();

        // $this->call("OthersTableSeeder");

    }

}
