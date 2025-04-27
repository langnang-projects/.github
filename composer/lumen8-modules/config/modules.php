<?php

use Nwidart\Modules\Activators\FileActivator;
use Nwidart\Modules\Commands;

return [

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

  'stubs' => [
    'enabled' => false,
    'path' => base_path('vendor/nwidart/laravel-modules/src/Commands/stubs'),
    'files' => [
      'routes/web' => 'Routes' . DIRECTORY_SEPARATOR . 'web.php',
      'routes/api' => 'Routes' . DIRECTORY_SEPARATOR . 'api.php',
      'views/index' => 'Resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'index.blade.php',
      'views/master' => 'Resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'master.blade.php',
      'scaffold/config' => 'Config' . DIRECTORY_SEPARATOR . 'config.php',
      'composer' => 'composer.json',
      'assets/js/app' => 'Resources' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'app.js',
      'assets/sass/app' => 'Resources' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'sass' . DIRECTORY_SEPARATOR . 'app.scss',
      'webpack' => 'webpack.mix.js',
      'package' => 'package.json',
    ],
    'replacements' => [
      'routes/web' => ['LOWER_NAME', 'STUDLY_NAME'],
      'routes/api' => ['LOWER_NAME'],
      'webpack' => ['LOWER_NAME'],
      'json' => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE'],
      'views/index' => ['LOWER_NAME'],
      'views/master' => ['LOWER_NAME', 'STUDLY_NAME'],
      'scaffold/config' => ['STUDLY_NAME'],
      'composer' => [
        'LOWER_NAME',
        'STUDLY_NAME',
        'VENDOR',
        'AUTHOR_NAME',
        'AUTHOR_EMAIL',
        'MODULE_NAMESPACE',
        'PROVIDER_NAMESPACE',
      ],
    ],
    'gitkeep' => true,
  ],
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

    'modules' => base_path('modules'),
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

    'migration' => base_path('database/migrations'),
    /*
    |--------------------------------------------------------------------------
    | Generator path
    |--------------------------------------------------------------------------
    | Customise the paths where the folders will be generated.
    | Set the generate key to false to not generate that folder
    */
    'generator' => [
      'config' => ['path' => 'Config', 'generate' => true],
      'command' => ['path' => 'Console', 'generate' => false],
      'migration' => ['path' => 'Database' . DIRECTORY_SEPARATOR . 'Migrations', 'generate' => true],
      'seeder' => ['path' => 'Database' . DIRECTORY_SEPARATOR . 'Seeders', 'generate' => true],
      'factory' => ['path' => 'Database' . DIRECTORY_SEPARATOR . 'factories', 'generate' => true],
      'model' => ['path' => 'Models', 'generate' => true],
      'routes' => ['path' => 'Routes', 'generate' => true],
      'controller' => ['path' => 'Http' . DIRECTORY_SEPARATOR . 'Controllers', 'generate' => true],
      'filter' => ['path' => 'Http' . DIRECTORY_SEPARATOR . 'Middleware', 'generate' => true],
      'request' => ['path' => 'Http' . DIRECTORY_SEPARATOR . 'Requests', 'generate' => true],
      'provider' => ['path' => 'Providers', 'generate' => true],
      'assets' => ['path' => 'Resources' . DIRECTORY_SEPARATOR . 'assets', 'generate' => false],
      'lang' => ['path' => 'Resources' . DIRECTORY_SEPARATOR . 'lang', 'generate' => false],
      'views' => ['path' => 'Resources' . DIRECTORY_SEPARATOR . 'views', 'generate' => false],
      'test' => ['path' => 'Tests' . DIRECTORY_SEPARATOR . 'Unit', 'generate' => false],
      'test-feature' => ['path' => 'Tests' . DIRECTORY_SEPARATOR . 'Feature', 'generate' => false],
      'repository' => ['path' => 'Repositories', 'generate' => false],
      'event' => ['path' => 'Events', 'generate' => false],
      'listener' => ['path' => 'Listeners', 'generate' => false],
      'policies' => ['path' => 'Policies', 'generate' => false],
      'rules' => ['path' => 'Rules', 'generate' => false],
      'jobs' => ['path' => 'Jobs', 'generate' => false],
      'emails' => ['path' => 'Emails', 'generate' => false],
      'notifications' => ['path' => 'Notifications', 'generate' => false],
      'resource' => ['path' => 'Transformers', 'generate' => false],
      'component-view' => ['path' => 'Resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'components', 'generate' => false],
      'component-class' => ['path' => 'View' . DIRECTORY_SEPARATOR . 'Components', 'generate' => false],
    ],
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
  'commands' => [
    Commands\CommandMakeCommand::class,
    Commands\ComponentClassMakeCommand::class,
    Commands\ComponentViewMakeCommand::class,
    Commands\ControllerMakeCommand::class,
    Commands\DisableCommand::class,
    Commands\DumpCommand::class,
    Commands\EnableCommand::class,
    Commands\EventMakeCommand::class,
    Commands\JobMakeCommand::class,
    Commands\ListenerMakeCommand::class,
    Commands\MailMakeCommand::class,
    Commands\MiddlewareMakeCommand::class,
    Commands\NotificationMakeCommand::class,
    Commands\ProviderMakeCommand::class,
    Commands\RouteProviderMakeCommand::class,
    Commands\InstallCommand::class,
    Commands\ListCommand::class,
    Commands\ModuleDeleteCommand::class,
    Commands\ModuleMakeCommand::class,
    Commands\FactoryMakeCommand::class,
    Commands\PolicyMakeCommand::class,
    Commands\RequestMakeCommand::class,
    Commands\RuleMakeCommand::class,
    Commands\MigrateCommand::class,
    Commands\MigrateRefreshCommand::class,
    Commands\MigrateResetCommand::class,
    Commands\MigrateRollbackCommand::class,
    Commands\MigrateStatusCommand::class,
    Commands\MigrationMakeCommand::class,
    Commands\ModelMakeCommand::class,
    Commands\PublishCommand::class,
    Commands\PublishConfigurationCommand::class,
    Commands\PublishMigrationCommand::class,
    Commands\PublishTranslationCommand::class,
    Commands\SeedCommand::class,
    Commands\SeedMakeCommand::class,
    Commands\SetupCommand::class,
    Commands\UnUseCommand::class,
    Commands\UpdateCommand::class,
    Commands\UseCommand::class,
    Commands\ResourceMakeCommand::class,
    Commands\TestMakeCommand::class,
    Commands\LaravelModulesV6Migrator::class,
    Commands\ComponentClassMakeCommand::class,
    Commands\ComponentViewMakeCommand::class,
  ],

  /*
  |--------------------------------------------------------------------------
  | Scan Path
  |--------------------------------------------------------------------------
  |
  | Here you define which folder will be scanned. By default will scan vendor
  | directory. This is useful if you host the package in packagist website.
  |
  */

  'scan' => [
    'enabled' => false,
    'paths' => [
      base_path('vendor/*/*'),
    ],
  ],
  /*
  |--------------------------------------------------------------------------
  | Composer File Template
  |--------------------------------------------------------------------------
  |
  | Here is the config for composer.json file, generated by this package
  |
  */

  'composer' => [
    'vendor' => 'nwidart',
    'author' => [
      'name' => 'Nicolas Widart',
      'email' => 'n.widart@gmail.com',
    ],
    'composer-output' => false,
  ],

  /*
  |--------------------------------------------------------------------------
  | Caching
  |--------------------------------------------------------------------------
  |
  | Here is the config for setting up caching feature.
  |
  */
  'cache' => [
    'enabled' => false,
    'key' => 'laravel-modules',
    'lifetime' => 60,
  ],
  /*
  |--------------------------------------------------------------------------
  | Choose what laravel-modules will register as custom namespaces.
  | Setting one to false will require you to register that part
  | in your own Service Provider class.
  |--------------------------------------------------------------------------
  */
  'register' => [
    'translations' => true,
    /**
     * load files on boot or register method
     *
     * Note: boot not compatible with asgardcms
     *
     * @example boot|register
     */
    'files' => 'register',
  ],

  /*
  |--------------------------------------------------------------------------
  | Activators
  |--------------------------------------------------------------------------
  |
  | You can define new types of activators here, file, database etc. The only
  | required parameter is 'class'.
  | The file activator will store the activation status in storage/installed_modules
  */
  'activators' => [
    'file' => [
      'class' => FileActivator::class,
      'statuses-file' => base_path('modules_statuses.json'),
      'cache-key' => 'activator.installed',
      'cache-lifetime' => 604800,
    ],
  ],

  'activator' => 'file',
];
