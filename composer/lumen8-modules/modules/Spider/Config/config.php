<?php

return [
    'name' => 'Spider',
    'nameCn' => '爬虫',
    'slug' => "spider",
    'relation_meta' => env('SPIDER_RELATION_META') ?? 0,
    'metas' => [],
    'contents' => [
        [
            'title' => 'Spider - Template',
            'text' => '<!--markdown-->

<!--more-->

----------
```ini
ico = 
url = 
[spider]
name = 
keywords[] = 
description = 
domains[] = 
scan_urls[] =
list_url_regexes[] = 
content_url_regexes[] = 

fields.name[0] =
fields.name[1] =

fields.selector[0] =

fields.required[0] =

fields.repeated[0] =

fields.default[0] =

fields.filter[0] =
```
',
            'type' => 'template',
            'status' => 'publish',
        ],
        [
            'title' => '',
            'slug' => 'nfyingshi',
            'text' => "<!--markdown-->
奈菲影视,是专为中国用户提供奈飞中文电影的网站,奈飞中文


<!--more-->

----------
```ini
ico = https://www.nfyingshi.com/wp-content/themes/mibt/favicon.ico
url = https://www.nfyingshi.com/
[spider]
name = nfyingshi
slug = nfyingshi
domains[] = nfyingshi.com
domains[] = www.nfyingshi.com
scan_urls[] = https://www.nfyingshi.com/
list_url_regexes[] = https://www.nfyingshi.pro/movie_bt\d+
content_url_regexes[] = https://www.nfyingshi.com/movie/\d+.html
fields[0] = title 
fields.name[0] = title
fields.selector[0] = //div[contains(@class,'moviedteail_tt')]//h1
fields.required[0] = true
fields.repeated[0] = false
fields.default[0] =
fields.filter[0] =
```

"
        ]
    ]
];
