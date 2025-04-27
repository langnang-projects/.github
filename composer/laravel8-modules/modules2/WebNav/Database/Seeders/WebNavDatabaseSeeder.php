<?php

namespace Modules\WebNav\Database\Seeders;

use App\Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class WebNavDatabaseSeeder extends Seeder
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
        $parent = \App\Models\Meta::where('slug', 'module:webnav')->where('user_id', 0)->first()->id;
        foreach (\App\Models\Meta::factory(30)->make() as $meta) {
            $meta->parent = $parent;
            $meta->save();
        }
        // \Modules\WebNav\Models\WebNav::factory(30)->create();
    }
}
