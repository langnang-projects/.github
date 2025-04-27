<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $globalMetaStatusOption = unserialize(\App\Models\Option::where('name', 'global.status')->where('user_id', 0)->first('value')->value);
        // var_dump($globalMetaStatusOption);
        //
        \App\Models\Meta::upsert(
            ['name' => "Module:Home", 'slug' => 'module:home', 'type' => 'module', 'status' => 'public'],
            ['slug'],
            ['name', 'type', 'status']
        );
        foreach (\Module::allEnabled() as $moduleName => $moduleObject) {
            \App\Models\Meta::upsert(
                ['name' => "Module:" . $moduleName, 'slug' => 'module:' . $moduleObject->getAlias(), 'type' => 'module', 'status' => config($moduleObject->getAlias() . '.status', 'public')],
                ['slug'],
                ['name', 'type', 'status']
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
    }
}
