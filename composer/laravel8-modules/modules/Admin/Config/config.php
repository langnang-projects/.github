<?php

return array(
    'name' => 'Admin',
    'nameCn' => '管理',
    'slug' => 'admin',
    'status' => 'private',
    'roles' => [],
    'title' => 'Laravel Modular',
    'prefix' => 'admin',
    'logo' => asset('modules/Admin/Public/master/img/AdminLTELogo.png'),
    'key' => '',
    'md5' => '',
    'component' => NULL,
    'framework' => 'adminlte',
    'ui' => 'adminlte',
    'layout' => 'master',
    'theme' => 'master',
    'views' => [
        'content_item' => 'data.content-item',
        'content_list' => 'data.content-list',
    ],
    'web' =>
        array(
            'prefix' => NULL,
        ),
    'navbar' =>
        array(
            'prefix' => NULL,
        ),
    'sidebar' =>
        array(
            'prefix' => NULL,
        ),
    'admin' =>
        array(
            'sidebar' =>
                array(
                    0 =>
                        array(
                            'path' => '/dashboard',
                            'title' => '总览面板',
                            'icon' => 'fas fa-tachometer-alt',
                            'slug' => '',
                            'order' => -1,
                            'children' =>
                                array(
                                    0 =>
                                        array(
                                            'path' => '/index',
                                            'title' => 'Dashboard v1',
                                            'children' =>
                                                array(),
                                        ),
                                    1 =>
                                        array(
                                            'path' => '/index2',
                                            'title' => 'Dashboard v2',
                                            'children' =>
                                                array(),
                                        ),
                                    2 =>
                                        array(
                                            'path' => '/index3',
                                            'title' => 'Dashboard v3',
                                            'children' =>
                                                array(),
                                        ),
                                ),
                        ),
                    1 =>
                        array(
                            'path' => '/data',
                            'title' => '数据管理',
                            'icon' => 'fas fa-database',
                            'slug' => '',
                            'children' => [
                                [
                                    "path" => '/meta',
                                    'title' => 'Meta',
                                    'children' => [],
                                ],
                                [
                                    "path" => '/content',
                                    'title' => 'Content',
                                    'children' => [
                                        [
                                            'path' => '/insert',
                                            'title' => 'Create Content',
                                            'visible' => false,
                                        ],
                                        [
                                            'path' => '/{id}',
                                            'title' => 'Update Content',
                                            'visible' => false,
                                        ],
                                    ],
                                ],
                                [
                                    "path" => '/comment',
                                    'title' => 'Comment',
                                    'children' => [],
                                ],
                                [
                                    "path" => '/link',
                                    'title' => 'Link',
                                    'children' => [],
                                ],
                                [
                                    "path" => '/log',
                                    'title' => 'Log',
                                    'children' => [],
                                ],
                                [
                                    "path" => '/import',
                                    'title' => 'Import',
                                    'children' => [],
                                ],
                                [
                                    "path" => '/export',
                                    'title' => 'Export',
                                    'children' => [],
                                ],
                            ],
                        ),
                    2 =>
                        array(
                            'path' => '/user',
                            'title' => '用户管理',
                            'icon' => 'fas fa-users',
                            'slug' => '',
                            'order' => 9223372036854775805,
                            'children' =>
                                array(),
                        ),
                    3 =>
                        array(
                            'path' => '/collection',
                            'title' => '藏品合集',
                            'icon' => 'fas fa-users',
                            'slug' => '',
                            'order' => 9223372036854775806,
                            'method' => 'view_library',
                            'children' =>

                                array(),
                        ),
                    4 =>
                        array(
                            'path' => '/modules',
                            'title' => '模块管理',
                            'icon' => 'fas fa-users',
                            'slug' => '',
                            'children' =>

                                array(),
                        ),
                    5 =>
                        array(
                            'path' => '/system',
                            'title' => '系统管理',
                            'icon' => 'fab fa-windows',
                            'slug' => '',
                            'order' => 9223372036854775807,
                            'children' =>
                                array(
                                    0 =>
                                        array(
                                            'path' => '/config',
                                            'title' => '配置管理',
                                            'children' =>
                                                array(),
                                        ),
                                    1 =>
                                        array(
                                            'path' => '/menu',
                                            'title' => '目录管理',
                                            'children' =>
                                                array(),
                                        ),
                                    2 =>
                                        array(
                                            'path' => '/database',
                                            'title' => '数据管理',
                                            'children' =>
                                                array(),
                                        ),
                                    3 =>
                                        array(
                                            'path' => '/artisan',
                                            'title' => '命令管理',
                                            'children' =>
                                                array(
                                                    [
                                                        'path' => '/migration',
                                                        'title' => '数据库迁移',
                                                        'visible' => false,
                                                    ],
                                                    [
                                                        'path' => '/seeding',
                                                        'title' => '数据填充',
                                                        'visible' => false,
                                                    ],
                                                ),
                                        ),
                                    4 =>
                                        array(
                                            'path' => '/modules',
                                            'title' => '应用管理',
                                            'children' =>
                                                array(
                                                    array(
                                                        'path' => '/{module}',
                                                        'title' => 'Config',
                                                        'visible' => false,
                                                    ),
                                                ),
                                        ),
                                    5 =>
                                        array(
                                            'path' => '/helpers',
                                            'title' => '辅助参考',
                                            'function' => "view_system_helpers",
                                            'children' =>
                                                array(),
                                        ),
                                ),
                        ),
                    6 =>
                        array(
                            'path' => '',
                            'title' => 'Dashboard',
                            'icon' => '',
                            'slug' => '',
                            'visible' => false,
                            'badge' =>
                                array(
                                    'type' => '',
                                    'value' => '',
                                ),
                            'children' =>
                                array(),
                        ),
                ),
        ),
    'type' => 'project',
    'description' => NULL,
);
