<?

array_push($_NOVEL_SOURCE, [
  "key" => "siluwx",
  "name" => "365小说网（siluwx.org）",
  "url" => "http://www.siluwx.org/",
  "class" => "siluwxController",
  "source" => "non_genuine",
]);
class siluwxController extends SpiderController
{
  public static $list_fields = [
    [
      "name" => "list",
      "selector" => "//*[contains(@class,'listitem')]",
      "repeated" => true,
      "children" => [
        [
          "name" => "__url__",
          "selector" => "//*[contains(@class,'cover')]/@href",
        ],
        [
          "name" => "id",
          "selector" => "//*[contains(@class,'book-info-title')]//a/@data-bid",
        ],
        [
          "name" => "name",
          "selector" => "//*[contains(@class,'bookdesc')]/a/h2",
        ],
        [
          "name" => "cover",
          "selector" => "//img",
        ],
        [
          "name" => "intro",
          "selector" => "//*[contains(@class,'desc')][2]",
        ],
        [
          "name" => "author",
          "selector" => "//*[contains(@class,'sp')]",
          "children" => [
            [
              "name" => "name",
              "selector" => "//span[1]"
            ]
          ]
        ],
        [
          "name" => "latest_chapter",
          "selector" => "//*[contains(@class,'desc')][1]",
          "children" => [
            [
              "name" => "__url__",
              // "selector" => "//a/@href",
            ],
            [
              "name" => "title",
              "selector" => "/a",
            ],
            [
              "name" => "time",
              // "selector" => "//span",
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
      "selector" => "//*[contains(@class,'bookdcover')]//img/@alt",
    ],
    [
      "name" => "cover",
      "selector" => "//*[contains(@class,'bookdcover')]//img",
    ],
    [
      "name" => "intro",
      "selector" => "//*[contains(@class,'book-intro')]"
    ],
    [
      "name" => "author",
      "description" => "作者",
      "selector" => "//*[contains(@class,'bookdmore')]/p[3]",
      "children" => [
        [
          "name" => "name",
          "selector" => "//a"
        ],
        [
          "name" => "__url__",
          "selector" => "//a/@href"
        ]
      ]
    ],
    [
      "name" => "charpter_latest",
      "description" => "最新章节",
      "selector" => "(//h2[@class='book_name'])[last()]/a",
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
      "selector" => "//dl//dd",
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
      "selector" => "//*[contains(@class,'bookd-title')]/h1",
    ],
    [
      "name" => "content",
      "description" => "",
      "selector" => "//*[contains(@id,'content')]//*[contains(@id,'content')]",
    ],
    [
      "name" => "prev",
      "description" => "",
      "selector" => "(//*[contains(@class,'bottem1')])[1]",
      "children" => [
        [
          "name" => "__url__",
          "selector" => "//a[2]/@href"
        ]

      ]
    ],
    [
      "name" => "next",
      "description" => "",
      "selector" => "(//*[contains(@class,'bottem1')])[1]",
      "children" => [
        [
          "name" => "__url__",
          "selector" => "//a[4]/@href"
        ]
      ]
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
    ]
  ];
  function get_info_id($info_url)
  {
    return substr($info_url, strpos($info_url, 'book/') + strlen('book/'), -1);
  }
  function get_chapter_id($chapter_url)
  {
    return substr(strrchr($chapter_url, '/'), 1, -strlen(".html"));
  }
  function on_get_list_url($info_name)
  {
    return "http://www.siluwx.org/Search?wd={$info_name}";
  }
  function on_extract_list_item_fields($fields)
  {
    $fields['id'] = $this->get_info_id($fields['__url__']);
    $fields['__url__'] = "http://www.siluwx.org" . $fields['__url__'];
    $fields['cover'] = "http://www.siluwx.org" . $fields['cover'];
    return $fields;
  }
  function on_get_info_url($info_id)
  {
    return "http://www.siluwx.org/book/{$info_id}/";
  }
  function on_extract_info_page($info)
  {
    $info['id'] = $this->get_info_id($info['__url__']);
    $info['cover'] = "http://www.siluwx.org" . $info['cover'];
    $info['author']['__url__'] = "http://www.siluwx.org" . ['author']['__url__'];
    // $info['name'] = substr($info['name'], 0, strpos($info['name'], '&#13;'));
    return $info;
  }
  function on_get_catalog_url($info_id)
  {
    return "http://www.siluwx.org/book/{$info_id}/index.html";
  }
  function on_extract_catalog_item_fields($fields)
  {
    $fields['id'] = $this->get_chapter_id($fields['__url__']);
    return $fields;
  }
  function on_get_chapter_url($info_chapter_id)
  {
    return "http://www.siluwx.org/book/{$info_chapter_id}.html";
  }
  function on_extract_chapter_page($chapter)
  {
    $chapter['id'] = $this->get_chapter_id($chapter['__url__']);
    $chapter['prev']['__url__'] = "http://www.siluwx.org" . $chapter['prev']['__url__'];
    $chapter['prev']['id'] = $this->get_chapter_id($chapter['prev']['__url__']);
    if ($chapter['prev']['id'] == 'index') unset($chapter['prev']);
    $chapter['next']['__url__'] = "http://www.siluwx.org" . $chapter['next']['__url__'];
    $chapter['next']['id'] = $this->get_chapter_id($chapter['next']['__url__']);
    if ($chapter['next']['id'] == 'index') unset($chapter['next']);
    return $chapter;
  }
}
