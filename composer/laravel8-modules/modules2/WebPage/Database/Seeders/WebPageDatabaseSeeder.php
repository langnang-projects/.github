<?php

namespace Modules\WebPage\Database\Seeders;

use App\Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class WebPageDatabaseSeeder extends Seeder
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

        // var_dump($this->getInitializaions('webpages'));

        \Modules\WebPage\Models\WebPage::upsert($this->getInitializaions('webpages'), ['slug'], ['slug', 'title', 'ico', 'description', "style", 'html', 'script', 'type', 'status']);
    }
}
