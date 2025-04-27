<?

array_push($_NOVEL_SOURCE, [
  "key" => "kankezw",
  "name" => "奇书网（kankezw.com）",
  "url" => "https://www.kankezw.com/",
  "class" => "KanKeZWController",
  "source" => "txt_genuine",
]);
class KanKeZWController extends SpiderController
{
  public static $list_fields = [
    [
      "name" => "list",
      "selector" => "//*[contains(@class,'grid')]//tr",
      "repeated" => true,
      "children" => [
        [
          "name" => "__url__",
          "selector" => "//td[2]/a/@href",
        ],
        [
          "name" => "id",
          "selector" => "//*[contains(@class,'book-info-title')]//a/@data-bid",
        ],
        [
          "name" => "name",
          "selector" => "//td[2]/a",
        ],
        [
          "name" => "cover",
          "selector" => "//*[contains(@class,'se-result-book')]//img",
        ],
        [
          "name" => "intro",
        ],
        [
          "name" => "author",
          "selector" => "//td[3]",
          "children" => [
            [
              "name" => "name",
              "selector" => "./body/p"
            ],
            [
              "name" => "__url__",
              "selector" => "//a[1]/@href"
            ]
          ]
        ],
        [
          "name" => "latest_chapter",
          "selector" => ".",
          "children" => [
            [
              "name" => "__url__",
              "selector" => "//td[4]//a/@href",
            ],
            [
              "name" => "title",
              "selector" => "//td[4]//a",
            ],
            [
              "name" => "time",
              "selector" => "//td[5]",
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
      "selector" => "//*[contains(@class,'detail_info')]//h1",
    ],
    [
      "name" => "cover",
      "description" => "封面",
      "selector" => "//*[contains(@class,'detail_pic')]//img",
    ],
    [
      "name" => "intro",
      "selector" => "//*[contains(@class,'showInfo')]//p[1]"
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
    ],
    [
      "name" => "txt",
    ]
  ];
  public static $catalog_fields = [
    [
      "name" => "catalog",
      "selector" => "(//*[contains(@class,'pc_list')])[2]//li",
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
      "selector" => "//*[contains(@class,'txt_cont')]//h1",
    ],
    [
      "name" => "content",
      "description" => "",
      "selector" => "//*[contains(@id,'content1')]",
    ],
    [
      "name" => "time",
      "selector" => "//*[contains(@class,'bookinfo')]/span[2]"
    ],
    [
      "name" => "prev",
      "description" => "",
      "selector" => "(//*[contains(@class,'txt_lian')])[2]",
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
      "selector" => "(//*[contains(@class,'txt_lian')])[2]",
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
    return substr(strrchr($info_url, '/Shtml'), 6, -strlen(".html"));
  }
  function on_get_list_url($info_name)
  {
    return "https://www.kankezw.com/search.html?searchkey={$info_name}";
  }
  function on_extract_list_item_fields($fields)
  {
    if (!$fields['__url__']) {
      return false;
    }
    $fields['id'] = $this->get_info_id($fields['__url__']);
    $fields['author']['id'] = substr(strrchr($fields['author']['__url__'], '/'), 1, -strlen(".html"));
    $fields['__url__'] = "https://www.kankezw.com" . $fields['__url__'];
    $fields['latest_chapter']['__url__'] = "https://www.kankezw.com" . $fields['latest_chapter']['__url__'];
    $fields['latest_chapter']['time'] = '20' . trim($fields['latest_chapter']['time']);
    return $fields;
  }
  function on_get_info_url($info_id)
  {
    return "https://www.kankezw.com/Shtml{$info_id}.html";
  }
  function on_extract_info_page($info)
  {
    $info['id'] = $this->get_info_id($info['__url__']);
    $info['name'] = substr($info['name'], strlen("《"), -strlen('》全集'));
    $info['txt'] = "https://dzs.kankezw.com/" . substr($info['id'], 0, 2) . "/" . $info['id'] . "/" . $info["name"] . ".txt";
    $info['cover'] = "https://www.kankezw.com" . $info['cover'];
    return $info;
  }
  function on_get_catalog_url($info_id)
  {
    return "https://www.kankezw.com/du/" . substr($info_id, 0, 2) . "/{$info_id}/";
  }
  function on_extract_catalog_item_fields($fields, $data, $html, $url)
  {
    $fields['id'] = substr($fields['__url__'], 0, -strlen(".html"));
    $fields['__url__'] = $url . $fields['__url__'];
    return $fields;
  }
  function on_get_chapter_url($info_chapter_id)
  {
    return "https://www.kankezw.com/du/" . substr($info_chapter_id, 0, 2) . "/{$info_chapter_id}.html";
  }
  function on_extract_chapter_page($chapter)
  {
    $chapter['id'] = substr(strrchr($chapter['__url__'], '/'), strlen("/"), -strlen(".html"));
    $chapter['content'] = substr($chapter['content'], strlen('<p class="sitetext">最新网址：www.kankezw.com</p>&#13;>&#13;') + 1, -strlen('<p class="sitetext">最新网址：www.kankezw.com</p>'));
    if (!strpos($chapter['prev']['__url__'], ".html")) {
      unset($chapter['prev']);
    } else {
      $chapter['prev']['id'] = substr($chapter['prev']['__url__'], 0, -strlen(".html"));
      $chapter['prev']['__url__'] = substr($chapter['__url__'], 0, strrpos($chapter['__url__'], '/')) . "/" . $chapter['prev']['__url__'];
    }
    if (!strpos($chapter['next']['__url__'], ".html")) {
      unset($chapter['next']);
    } else {
      $chapter['next']['id'] = substr($chapter['next']['__url__'], 0, -strlen(".html"));
      $chapter['next']['__url__'] = substr($chapter['__url__'], 0, strrpos($chapter['__url__'], '/')) . "/" . $chapter['next']['__url__'];
    }
    return $chapter;
  }
}
