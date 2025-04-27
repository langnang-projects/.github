<?

array_push($_NOVEL_SOURCE, [
  "key" => "qidian",
  "name" => "起点中文网",
  "url" => "https://www.qidian.com/",
  "class" => "QiDianController",
  "source" => "genuine",
]);

class QiDianController extends SpiderController
{
  public static $list_fields = [
    [
      "name" => "list",
      "selector" => "//*[contains(@class,'res-book-item')]",
      "repeated" => true,
      "children" => [
        [
          "name" => "__url__",
          "selector" => "//*[contains(@class,'book-info-title')]//a/@href",
        ],
        [
          "name" => "id",
          "selector" => "//*[contains(@class,'book-info-title')]//a/@data-bid",
        ],
        [
          "name" => "name",
          "selector" => "//*[contains(@class,'book-info-title')]//a/@title",
        ],
        [
          "name" => "cover",
          "selector" => "//*[contains(@class,'book-img-box')]//img",
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
      "selector" => "//*[contains(@class,'book-information')]//*[@class='book-img']//a/@data-bid",
    ],
    [
      "name" => "name",
      "selector" => "//*[contains(@class,'book-info')]/h1/em",
    ],
    [
      "name" => "cover",
      "description" => "封面",
      "selector" => "//*[contains(@class,'book-information')]//*[@class='book-img']//img",
    ],
    [
      "name" => "intro",
      "selector" => "//*[contains(@class,'book-intro')]"
    ],
    [
      "name" => "author",
      "description" => "作者",
      "selector" => "//*[contains(@class,'book-info')]/h1//*[contains(@class,'writer')]/@href",
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
      "selector" => "(//h2[@class='book_name'])[last()]/a/@href",
    ],
    [
      "name" => "charpter_alt_latest",
      "description" => "最新章节的属性",
      "selector" => "(//h2[@class='book_name'])[last()]/a/@alt",
    ]
  ];
  public static $catalog_fields = [
    [
      "name" => "catalog",
      "selector" => "//h2[contains(@class,'book_name')]",
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
      "selector" => "//*[contains(@class,'text-head')]//*[contains(@class,'content-wrap')]",
    ],
    [
      "name" => "content",
      "description" => "",
      "selector" => "//*[contains(@class,'read-content')]",
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
      "selector" => "//*[contains(@class,'chapter-control')]",
      "children" => [
        [
          "name" => "__url__",
          "selector" => "//a[1]/@href",
        ]
      ]
    ],
    [
      "name" => "next",
      "description" => "",
      "selector" => "//*[contains(@class,'chapter-control')]",
      "children" => [
        [
          "name" => "__url__",
          "selector" => "//a[3]/@href",
        ]
      ]
    ],
  ];
  function get_chapter_id($info_url)
  {
    return substr($info_url, strpos($info_url, 'chapter/') + strlen('chapter/'), -1);
  }
  function on_get_list_url($info_name)
  {
    return "https://www.qidian.com/soushu/{$info_name}.html";
  }
  function on_extract_list_item_fields($fields)
  {
    $fields['name'] = substr($fields['name'], 0, -12);
    return $fields;
  }
  function on_get_info_url($info_id)
  {
    return "https://book.qidian.com/info/{$info_id}/";
  }
  function on_extract_info_page($info)
  {
    $info['cover'] = trim($info['cover']);
    return $info;
  }
  function on_get_catalog_url($info_id)
  {
    return "https://book.qidian.com/info/{$info_id}/";
  }
  function on_extract_catalog_item_fields($fields)
  {
    // $fields['name'] = substr($fields['name'], 0, -12);
    $fields['id'] = $this->get_chapter_id($fields['__url__']);
    return $fields;
  }
  function on_get_chapter_url($info_chapter_id)
  {
    $info_chapter_id = substr($info_chapter_id, strpos($info_chapter_id, "/") + 1);
    return "https://read.qidian.com/chapter/{$info_chapter_id}/";
  }
  function on_extract_chapter_page($chapter)
  {
    $chapter['id'] = $this->get_chapter_id($chapter['__url__']);
    if ($chapter['prev']['__url__'] == 'javascript:void(0);') {
      unset($chapter['prev']);
    } else {
      $chapter['prev']['id'] = $this->get_chapter_id($chapter['prev']['__url__']);
    }
    if ($chapter['next']['__url__'] == 'javascript:void(0);') {
      unset($chapter['next']);
    } else {
      $chapter['next']['id'] = $this->get_chapter_id($chapter['next']['__url__']);
    }
    return $chapter;
  }
}
