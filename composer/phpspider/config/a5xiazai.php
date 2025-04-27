<?php

return array(
    "name" => "A5下载",
    'depth' => 3,
    'domains' => array(
        'a5xiazai.com',
        'www.a5xiazai.com',
    ),
    'scan_urls' => array(
        'https://www.a5xiazai.com/',
    ),
    'list_url_regexes' => array(
        "https://www.a5xiazai.com/qita/\.+",
        // "https://www.a5xiazai.com/8hr/page/\d+\?s=\d+",
    ),
    'content_url_regexes' => array(
        "https://www.a5xiazai.com/qita/\d+.html",
    ),
);
