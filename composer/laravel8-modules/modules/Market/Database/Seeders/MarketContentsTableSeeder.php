<?php

namespace Modules\Market\Database\Seeders;

use App\Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Modules\Market\Models\MarketContent;

class MarketContentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();
        // $this->getNpmProjectContents();
        $this->getThemeProjectContents();
        $this->getExampleProjectContents();
        // $this->call("OthersTableSeeder");
    }

    public function getNpmProjectContents()
    {
        // http://api.jsdelivr.com/v1/jsdelivr/libraries
        $return = Http::get('http://api.jsdelivr.com/v1/jsdelivr/libraries');
        Storage::put('api.jsdelivr.com/v1/jsdelivr/libraries', $return->body());
        // app('files')->replace();
        $return = array_map(function ($item) {
            // $item['title'] = $item['name'];
            // $item['slug'] = $item['name'];
            // $item['type'] = "npm-project";
            // unset($item['name'], $item['commit'], $item['protected']);
            return [
                'title' => $item['name'],
                'slug' => $item['name'],
                'type' => 'npm-project',
                // 'text' => $item,
            ];
        }, $return->json());
        MarketContent::upsert($return, ['slug'], ['title', 'type']);
    }

    public function getExampleProjectContents()
    {
        $return = Http::get('http://api.github.com/repos/ln-laravel-modular/example-packages/branches')->json();


        $return = array_map(function ($item) {
            $item['title'] = $item['name'];
            $item['slug'] = $item['name'];
            $item['type'] = "example-project";
            unset($item['name'], $item['commit'], $item['protected']);
            return $item;
        }, $return);
        // var_dump($return);
        MarketContent::upsert($return, ['slug'], ['title', 'type']);
    }
    public function getThemeProjectContents()
    {
        // http://api.github.com/repos/ln-laravel-modular/theme-packages/branches
        $return = Http::get('http://api.github.com/repos/ln-laravel-modular/theme-packages/branches')->json();

        $return = array_map(function ($item) {
            $item['title'] = $item['name'];
            $item['slug'] = $item['name'];
            $item['type'] = "theme-project";
            unset($item['name'], $item['commit'], $item['protected']);
            return $item;
        }, $return);
        // var_dump($return);
        MarketContent::upsert($return, ['slug'], ['title', 'type']);
    }
}
