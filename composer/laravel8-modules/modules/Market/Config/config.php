<?php

return [
    'name' => 'Market',
    'nameCn' => '市场',
    'slug' => "market",
    'title' => "Market",
    'prefix' => 'market',
    'layout' => "master",
    'web' => [
        'component' => '',
        'navbar' => [],
    ],
    'admin' => [
        'prefix' => 'admin',
        'navbar' => [],
        // 'sidebar' => [
        //     ["path" => "/market", "title" => "应用市场", "icon" => "fab fa-microsoft", "slug" => "", "order" => PHP_INT_MAX - 3,  "children" => []],
        // ],
    ],
    'projects' => [
        'software' => [],
        'module' => [],
        'example' => [],
        'theme' => [],
        'npm' => [],
    ],
    "extensions" => [
        "market.npm" => [],
        "market.composer" => [],
        "market.software" => [],
        "market.module" => [],
        "market.theme" => [],
        "market.example" => [],
    ],
    'branches' => [
        // 'empty' => [],
        'api-jsdelivr' => [
            "name" => "jsDelivr API",
            "slug" => "api-jsdelivr",
            "ico" => "https://www.jsdelivr.com/assets/319b54d90dd0a622bf60177e0f2c521b3998a6c5/img/icons/jsdelivr_icon.svg",
            "type" => "package",
            "tags" => ["search", "paginator"],
            "form" => [
                ["name" => "search", "type" => "input", "default" => "bootstrap"]
            ],
            "request_project_list" => [
                "url" => "http://api.jsdelivr.com/v1/jsdelivr/libraries?name=*{{\$search}}*",
                "response_type" => "array",
                "response_keys" => [
                    "name" => "name",
                    "description" => "description",
                    "lastversion" => "lastversion",
                ],
            ],
            "request_version_list" => [
                "url" => "http://api.jsdelivr.com/v1/jsdelivr/libraries?name={{\$name}}",
                "response_key" => "0",
                "response_type" => "object",
                "response_keys" => [
                    "name" => "name",
                    "description" => "description",
                    "versions" => "versions",
                ],
            ]
        ],
        'data-jsdelivr' => [
            "name" => "jsDelivr Data",
            "slug" => "data-jsdelivr",
            "ico" => "https://www.jsdelivr.com/assets/319b54d90dd0a622bf60177e0f2c521b3998a6c5/img/icons/jsdelivr_icon.svg",
            "tags" => ["paginator"],
            "request_version_list" => [
                "url" => "http://data.jsdelivr.com/v1/packages/npm/{{\$name}}",
                "response_keys" => [
                    "name" => "",
                    "description" => "",
                    "version" => "",
                ],
            ],
        ],
        'google' => [
            "name" => "Google",
            "slug" => "google",
            "ico" => "",
            "hidden" => true,
        ],
        'cdnjs' => [
            "name" => "CDNjs",
            "slug" => "cdnjs",
            "ico" => "https://cdnjs.com/favicon.png",
            "hidden" => true,
        ],
        'bootstrap' => [
            "name" => "Google",
            "slug" => "bootstrap",
            "ico" => "",
            "hidden" => true,
        ],
        'jquery' => [
            "name" => "jQuery",
            "slug" => "jquery",
            "ico" => "https://jquery.com/wp-content/themes/jquery.com/i/favicon.ico",
            "hidden" => true,
        ],
        'bootcdn' => [
            "name" => "BootCDN",
            "slug" => "bootcdn",
            "ico" => "https://api.bootcdn.cn/assets/ico/favicon.ico",
            "host" => "",
            "request_project_list" => [
                "url" => "http://api.jsdelivr.com/v1/jsdelivr/libraries?name=*{{\$search}}*",
                "response_type" => "array",
                "response_keys" => [
                    "name" => "",
                    "description" => "",
                ],
            ],
            "request_version_list" => [
                "url" => "https://api.bootcdn.cn/libraries/{{\$name}}",
            ],
        ],
        'github' => [
            "name" => "GitHub",
            "slug" => "github",
            'ico' => 'https://docs.github.com/assets/cb-345/images/site/favicon.png',
            "host" => "http://api.github.com",
            "request_project_list" => [
                "url" => "http://api.github.com/orgs/ln-laravel-modular/repos",
                "headers" => ["Accept: application/vnd.github+json"],
                "response_type" => "array",
                "response_keys" => [
                    "name" => "name",
                    "description" => "description",
                ],
            ],
            "request_version_list" => [
                "url" => "http://api.github.com/repos/ln-laravel-modular/{{\$name}}/branches",
                "response_type" => "array",
                "response_keys" => [
                    "name" => "name",
                    //     "description" => "description",
                    "versions" => "",
                ],
            ],
        ],

    ],
    'themes' => [],
    "examples" => [],
];
