<?

array_push($_NOVEL_SOURCE, [
  "key" => "zzs5",
  "name" => "猪猪书网（zzs5.com）",
  "url" => "http://www.zzs5.com/",
  "class" => "zzs5Controller",
  "source" => "txt_genuine",
]);

class zzs5Controller extends SpiderController
{
  public static $list_fields = [
    [
      "name" => "list",
      "selector" => "//*[contains(@class,'pages_table')]//tr",
      "repeated" => true,
      "children" => [
        [
          "name" => "__url__",
          "selector" => "//td[2]//a/@href",
        ],
        [
          "name" => "id",
          "selector" => "//*[contains(@class,'book-info-title')]//a/@data-bid",
        ],
        [
          "name" => "name",
          "selector" => "//td[2]//a",
        ],
        [
          "name" => "cover",
          "selector" => "//td[1]//img",
        ],
        [
          "name" => "intro",
          "selector" => "//*[contains(@class,'intro')]/text()",
        ],
        [
          "name" => "author",
          "selector" => "//*[contains(@class,'author')]",
          "children" => [
            [
              "name" => "name",
              "selector" => "//*[contains(@class,'name')]"
            ],
            [
              "name" => "__url__",
              "selector" => "//*[contains(@class,'name')]/@href"
            ]
          ]
        ],
        [
          "name" => "latest_chapter",
          "selector" => "//*[contains(@class,'update')]",
          "children" => [
            [
              "name" => "__url__",
              "selector" => "//a/@href",
            ],
            [
              "name" => "title",
              "selector" => "//a",
            ],
            [
              "name" => "time",
              "selector" => "//span",
            ],
          ]
        ],
      ],
    ]
  ];


  public static $info_fields = [
    [
      "name" => "id",
      "description" => "封面",
      "selector" => "//*[contains(@class,'book-information')]//*[@class='book-img']//a/@data-bid",
    ],
    [
      "name" => "name",
      "description" => "作品名称",
      "selector" => "//*[contains(@class,'show_title')]/h1",
    ],
    [
      "name" => "cover",
      "description" => "封面",
      "selector" => "//*[contains(@class,'book-information')]//*[@class='book-img']//img",
    ],
    [
      "name" => "intro",
      "selector" => "(//*[contains(@class,'show_content')])[1]/text()[1]"
    ],
    [
      "name" => "author",
      "description" => "作者",
      "selector" => "//*[contains(@class,'book-info')]/h1",
      "children" => [
        [
          "name" => "name",
          "selector" => "//*[contains(@class,'writer')]",
        ]
      ]
    ],
    [
      "name" => "charpter_latest",
      "description" => "最新章节",
      "selector" => "(//h2[@class='book_name'])[last()]/a",
    ],
    [
      "name" => "txt",
      "selector" => "(//*[@class='show_downlink']//a)[2]/@href",
    ]
  ];
  public static $catalog_fields = [
    [
      "name" => "catalog",
      "selector" => "//*[contains(@class,'list')]//dd",
      "repeated" => true,
      "children" => [
        [
          "name" => "__url__",
          "selector" => "//a/@href",
        ],
        [
          "name" => "title",
          "selector" => "//a",
        ],
        [
          "name" => "alt",
          "selector" => "//a/@alt",
        ],
      ]
    ]
  ];
  public static $chapter_fields = [
    [
      "name" => "title",
      "description" => "",
      "selector" => "//*[contains(@class,'bookd-title')]//h1",
    ],
    [
      "name" => "content",
      "description" => "",
      "selector" => "//*[contains(@class,'content')]//*[contains(@class,'content')]",
    ],
    [
      "name" => "book",
      "description" => "",
      "selector" => "//*[contains(@class,'text-head')]//*[contains(@class,'info')]//a[1]/text()",
    ],
    [
      "name" => "book_url",
      "description" => "",
      "selector" => "//*[contains(@class,'text-head')]//*[contains(@class,'info')]//a[1]/@href",
    ],
    [
      "name" => "author",
      "description" => "",
      "selector" => "//*[contains(@class,'text-head')]//*[contains(@class,'info')]//a[2]/text()",
    ],
    [
      "name" => "author_url",
      "description" => "",
      "selector" => "//*[contains(@class,'text-head')]//*[contains(@class,'info')]//a[2]/@href",
    ],
    [
      "name" => "prev",
      "description" => "",
      "selector" => "//*[contains(@class,'bottem1')]",
      "children" => [
        [
          "name" => "__url__",
          "selector" => "//a[2]/@href",
        ]
      ]
    ],
    [
      "name" => "next",
      "description" => "",
      "selector" => "//*[contains(@class,'bottem1')]",
      "children" => [
        [
          "name" => "__url__",
          "selector" => "//a[4]/@href",
        ]
      ]
    ],
  ];
  function get_info_id($info_url)
  {
    return substr($info_url, strpos($info_url, 'book/') + strlen('book/'), -1);
  }
  function on_get_list_url($info_name)
  {
    return "http://www.zzs5.com/index.php?m=search&q={$info_name}";
  }
  function on_extract_list_item_fields($fields)
  {
    $fields['id'] = substr($fields['__url__'], strpos($fields['__url__'], 'book/') + strlen('book/'), -1);
    return $fields;
  }
  function on_get_info_url($info_id)
  {
    return "http://www.zzs5.com/txt/{$info_id}.html";
  }
  function on_extract_info_page($info)
  {
    $info['cover'] = trim($info['cover']);
    $info['id'] = substr(strrchr($info['__url__'], '/'), 1, -strlen(".html"));
    // var_dump($info);
    return $info;
  }
  function on_get_catalog_url($info_id)
  {
    return "http://www.zzs5.com/book/{$info_id}/";
  }
  function on_extract_catalog_item_fields($fields)
  {
    $fields['id'] = substr(strrchr($fields['__url__'], '/'), 1, -strlen(".html"));
    $fields['__url__'] = "http://www.zzs5.com" . $fields['__url__'];
    return $fields;
  }
  function get_chapter_id($chapter_url)
  {
    return substr(strrchr($chapter_url, '/'), 1, -strlen(".html"));
  }
  function on_get_chapter_url($info_chapter_id)
  {
    return "http://www.zzs5.com/book/{$info_chapter_id}.html";
  }
  function on_extract_chapter_page($chapter)
  {
    $chapter['id'] = $this->get_chapter_id($chapter['__url__']);
    $chapter['prev']['id'] = substr(strrchr($chapter['prev']['__url__'], '/'), 1, -strlen(".html"));
    $chapter['prev']['__url__'] = "http://www.zzs5.com" . $chapter['prev']['__url__'];
    if (!$chapter['prev']['id']) unset($chapter['prev']);
    $chapter['next']['id'] = substr(strrchr($chapter['next']['__url__'], '/'), 1, -strlen(".html"));
    $chapter['next']['__url__'] = "http://www.zzs5.com" . $chapter['next']['__url__'];
    if (!$chapter['next']['id']) unset($chapter['next']);
    return $chapter;
  }
}
