<?php

namespace Modules\Admin\Database\Seeders;

use App\Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Storage;

class AdminDatabaseSeeder extends Seeder
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
        $adminMetaId = \App\Models\Meta::where('slug', 'module:admin')->first()->id;
        // var_dump($adminMeta);


        \App\Models\Meta::upsert(
            [
                ['slug' => 'admin:ssential', 'ico' => 'fas fa-tachometer-alt', 'name' => 'Essential', 'type' => 'category', 'status' => 'public', 'parent' => $adminMetaId],
                ['slug' => 'admin:modules', 'ico' => 'fas fa-tachometer-alt', 'name' => 'Modules', 'type' => 'category', 'status' => 'public', 'parent' => $adminMetaId],
                ['slug' => 'admin:laravel', 'ico' => 'fas fa-tachometer-alt', 'name' => 'Laravel', 'type' => 'category', 'status' => 'public', 'parent' => $adminMetaId],
            ],
            ['slug'],
            ['slug', 'ico', 'name', 'type', 'status', 'parent']
        );

        \App\Models\Meta::upsert(
            [
                ['slug' => 'admin:ssential:metas', 'ico' => '', 'name' => 'Metas', 'type' => 'category', 'status' => 'public', 'parent' => \App\Models\Meta::where('slug', 'admin:ssential')->first()->id],
                ['slug' => 'admin:ssential:contents', 'ico' => '', 'name' => 'Contents', 'type' => 'category', 'status' => 'public', 'parent' => \App\Models\Meta::where('slug', 'admin:ssential')->first()->id],
                ['slug' => 'admin:ssential:links', 'ico' => '', 'name' => 'Links', 'type' => 'category', 'status' => 'public', 'parent' => \App\Models\Meta::where('slug', 'admin:ssential')->first()->id],
                ['slug' => 'admin:ssential:options', 'ico' => '', 'name' => 'Options', 'type' => 'category', 'status' => 'public', 'parent' => \App\Models\Meta::where('slug', 'admin:ssential')->first()->id],
                ['slug' => 'admin:ssential:logs', 'ico' => '', 'name' => 'Logs', 'type' => 'category', 'status' => 'public', 'parent' => \App\Models\Meta::where('slug', 'admin:ssential')->first()->id],
            ],
            ['slug'],
            ['slug', 'ico', 'name', 'type', 'status', 'parent']
        );

        foreach (\Module::allEnabled() as $moduleName => $moduleObject) {
            if (!in_array($moduleName, ['Admin']))
                \App\Models\Meta::upsert(
                    ['slug' => 'admin:modules:' . $moduleObject->getAlias(), 'ico' => '', 'name' => $moduleName, 'type' => 'category', 'status' => config($moduleObject->getAlias() . '.status', 'public'), 'parent' => \App\Models\Meta::where('slug', 'admin:modules')->first()->id],
                    ['slug'],
                    ['slug', 'ico', 'name', 'type', 'status', 'parent']
                );
            // $moduleMeta = \App\Models\Meta::where('slug', 'module:' . $module->getAlias())->where('user', 0)->first();
            // foreach ($globalMetaStatusOption as $globalStatus) {
            //     $status = $globalStatus['value'];
            //     \App\Models\Meta::upsert(
            //         ['slug' => 'module:' . $module->getAlias() . ':' . $status, 'type' => 'module-status', 'status' => $status, 'parent' => $moduleMeta->id],
            //         ['slug'],
            //         ['type', 'status']
            //     );
            // }
        }


        \App\Models\Meta::upsert(
            [
                ['slug' => 'admin:laravel:migrations', 'ico' => '', 'name' => 'Migrations', 'type' => 'category', 'status' => 'public', 'parent' => \App\Models\Meta::where('slug', 'admin:laravel')->first()->id],
                ['slug' => 'admin:laravel:seeders', 'ico' => '', 'name' => 'Seeders', 'type' => 'category', 'status' => 'public', 'parent' => \App\Models\Meta::where('slug', 'admin:laravel')->first()->id],
            ],
            ['slug'],
            ['slug', 'ico', 'name', 'type', 'status', 'parent']
        );

    }
}
