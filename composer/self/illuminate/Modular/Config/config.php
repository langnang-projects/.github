<?php

return [

  'alias' => 'modular',
  'name' => 'Modular',
  'nameCn' => '模块加载器',
  /*
    |--------------------------------------------------------------------------
    | Module Namespace
    |--------------------------------------------------------------------------
    |
    | Default module namespace.
    |
    */

  'namespace' => 'Modules',

  /*
    |--------------------------------------------------------------------------
    | Module Stubs
    |--------------------------------------------------------------------------
    |
    | Default module stubs.
    |
    */

  'stubs' => [],
  'paths' => [
    /*
        |--------------------------------------------------------------------------
        | Modules path
        |--------------------------------------------------------------------------
        |
        | This path used for save the generated module. This path also will be added
        | automatically to list of scanned folders.
        |
        */

    'modules' => [
      base_path('modules'),
      base_path('..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '41000.simple' . DIRECTORY_SEPARATOR . 'projects' . DIRECTORY_SEPARATOR . 'WebSpider' . DIRECTORY_SEPARATOR . 'composer' . DIRECTORY_SEPARATOR . 'langnang-modules'),
    ],
    /*
        |--------------------------------------------------------------------------
        | Modules assets path
        |--------------------------------------------------------------------------
        |
        | Here you may update the modules assets path.
        |
        */

    'assets' => public_path('modules'),
    /*
        |--------------------------------------------------------------------------
        | The migrations path
        |--------------------------------------------------------------------------
        |
        | Where you run 'module:publish-migration' command, where do you publish the
        | the migration files?
        |
        */

    'migration' => base_path('database' . DIRECTORY_SEPARATOR . 'migrations'),
    /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Set the generate key to false to not generate that folder
        */
    'generator' => [],
  ],

  /*
    |--------------------------------------------------------------------------
    | Package commands
    |--------------------------------------------------------------------------
    |
    | Here you can define which commands will be visible and used in your
    | application. If for example you don't use some of the commands provided
    | you can simply comment them out.
    |
    */
  'commands' => [],

];
