<?php

return array(
    "name" => "起点中文网",
    'domains' => array(
        'qidian.com',
        'www.qidian.com'
    ),
    'scan_urls' => array(
        'https://www.qidian.com/'
    ),
    'list_url_regexes' => array(
        "https://www.qidian.com/8hr/page/\d+\?s=\d+"
    ),
    'content_url_regexes' => array(
        "https://www.qidian.com/article/\d+",
    ),
);
