<?php

namespace Modules\WebHunt\Database\Seeders;

use App\Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class WebHuntDatabaseSeeder extends Seeder
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

        $webhunts = array_map(function ($item) {
            $item['text'] = json_encode($item['text'], JSON_UNESCAPED_UNICODE);
            return $item;
        }, $this->getInitializaions('webhunts'));
        // var_dump($webhunts);
        \Modules\WebHunt\Models\WebHunt::upsert(
            $webhunts,
            ["slug"],
            ["ico", "title", "description", "text", "type", "status"]
        );
    }
}
