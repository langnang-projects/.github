<?

array_push($_NOVEL_SOURCE, [
  "key" => "zongheng",
  "name" => "纵横中文网",
  "url" => "http://www.zongheng.com/",
  "class" => "ZongHengController",
  "source" => "genuine",
]);
class ZongHengController extends SpiderController
{
  public static $list_fields = [
    [
      "name" => "list",
      "selector" => "//*[contains(@class,'search-result-list')]",
      "repeated" => true,
      "children" => [
        [
          "name" => "__url__",
          "selector" => "//*[contains(@class,'se-result-book')]//a/@href",
        ],
        [
          "name" => "id",
          "selector" => "//*[contains(@class,'book-info-title')]//a/@data-bid",
        ],
        [
          "name" => "name",
          "selector" => "//*[@class='tit']//a",
        ],
        [
          "name" => "cover",
          "selector" => "//*[contains(@class,'se-result-book')]//img",
        ],
        [
          "name" => "intro",
          "selector" => "//*[contains(@class,'se-result-infos')]/p",
        ],
        [
          "name" => "author",
          "selector" => "//*[contains(@class,'bookinfo')]",
          "children" => [
            [
              "name" => "name",
              "selector" => "//a[1]"
            ],
            [
              "name" => "__url__",
              "selector" => "//a[1]/@href"
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
      "selector" => "(//*[contains(@class,'book-name')])",
    ],
    [
      "name" => "cover",
      "description" => "封面",
      "selector" => "//*[contains(@class,'book-img')]//img",
    ],
    [
      "name" => "intro",
      "selector" => "//*[contains(@class,'book-dec')]//p"
    ],
    [
      "name" => "author",
      "description" => "作者",
      "selector" => "//*[contains(@class,'book-info')]/h1//*[contains(@class,'writer')]",
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
      "selector" => "//*[contains(@class,'chapter-list')]/li",
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
          "selector" => "//a/@title",
        ],
      ]
    ]
  ];
  public static $chapter_fields = [
    [
      "name" => "title",
      "description" => "",
      "selector" => "//*[contains(@class,'title_txtbox')]",
    ],
    [
      "name" => "content",
      "description" => "",
      "selector" => "//*[contains(@class,'content')]",
    ],
    [
      "name" => "time",
      "selector" => "//*[contains(@class,'bookinfo')]/span[2]"
    ],
    [
      "name" => "prev",
      "description" => "",
      "selector" => "//*[contains(@class,'chap_btnbox')]",
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
      "selector" => "//*[contains(@class,'chap_btnbox')]",
      "children" => [
        [
          "name" => "__url__",
          "selector" => "//a[3]/@href",
        ]
      ]
    ],
  ];
  function get_info_id($info_url)
  {
    return substr(strrchr($info_url, '/'), 1, -strlen(".html"));
  }
  function on_get_list_url($info_name)
  {
    return "http://search.zongheng.com/s?keyword={$info_name}";
  }
  function on_extract_list_item_fields($fields)
  {
    $fields['id'] = substr(strrchr($fields['__url__'], '/'), 1, -strlen(".html"));
    $fields['author']['id'] = substr(strrchr($fields['author']['__url__'], '/'), 1, -strlen(".html"));
    return $fields;
  }
  function on_get_info_url($info_id)
  {
    return "http://book.zongheng.com/book/{$info_id}.html";
  }
  function on_extract_info_page($info)
  {
    $info['id'] = $this->get_info_id($info['__url__']);
    $info['name'] = substr($info['name'], 0, strpos($info['name'], '&#13;'));
    return $info;
  }
  function on_get_catalog_url($info_id)
  {
    return "http://book.zongheng.com/showchapter/{$info_id}.html";
  }
  function on_extract_catalog_item_fields($fields)
  {
    $fields['id'] = substr(strrchr($fields['__url__'], '/'), strlen("/"), -strlen(".html"));
    $fields['time'] = substr(strrchr($fields['alt'], '更新时间：'), strlen("更新时间："));
    $fields['time'] = substr(strrchr($fields['alt'], '更新时间：'), 9);
    return $fields;
  }
  function on_get_chapter_url($info_chapter_id)
  {
    return "http://book.zongheng.com/chapter/{$info_chapter_id}.html";
  }
  function on_extract_chapter_page($chapter)
  {
    $chapter['id'] = substr(strrchr($chapter['__url__'], '/'), strlen("/"), -strlen(".html"));
    if ($chapter['prev']['__url__'] == 'javascript:void(0)') {
      unset($chapter['prev']);
    } else {
      $chapter['prev']['id'] = substr(strrchr($chapter['prev']['__url__'], '/'), strlen("/"), -strlen(".html"));
    }
    if ($chapter['next']['__url__'] == 'javascript:void(0)') {
      unset($chapter['next']);
    } else {
      $chapter['next']['id'] = substr(strrchr($chapter['next']['__url__'], '/'), strlen("/"), -strlen(".html"));
    }
    return $chapter;
  }
}
