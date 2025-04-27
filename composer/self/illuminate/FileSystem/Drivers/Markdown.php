<?php

namespace Illuminate\FileSystem\Drivers;


/**
 * Markdown 文件驱动
 * @var string $content
 * @var array $config
 * @var array $tree
 * 
 * 
 * @method mixed to_text
 * @method mixed to_html
 */
class Markdown
{
  use \Illuminate\File\Traits\FileDriverTrait;

  private $path;
  /**
   * Summary of tree
   * @var array
   */
  private $tree = [];
  public function setTree(array $value)
  {
    $this->tree = $value;
  }
  public function getTree()
  {
    return $this->tree;
  }
  /**
   * Summary of content
   * @var string
   */
  private $content = "";
  public function setContent(string $value)
  {
    $value = preg_replace(['/\n(\s+)\r/'], ["\n\r"], $value);
    $this->content = $value;
  }
  public function getContent()
  {
    return $this->content;
  }
  private $config = [];

  public function setConfig(array $value)
  {
    $this->config = array_merge($this->config, $value);
  }
  public function getConfig()
  {
    return $this->config;
  }
  private $aliases = [
    // 全文匹配 "/\n".$pattern."\r/"
    // 单行匹配 "/^".$pattern."$/"
    // 空行
    "empty" => [
      "pattern" => "\s+",
      "replace" => "",
    ],
    // 标题
    "h1" => [
      "pattern" => "# (.+)",
      "replace" => '<h1 id="${1}" style="margin-left: -1.5rem;"><a href="#">§</a> ${1} </h1>',
    ],
    "h2" => [
      "pattern" => "## (.+)",
      "replace" => '<h2 id="${1}" style="margin-left: -1.5rem;"><a href="#">§</a> ${1} </h2>',
    ],
    "h3" => [
      "pattern" => "### (.+)",
      "replace" => '<h3 id="${1}" style="margin-left: -1.5rem;"><a href="#">§</a> ${1} </h3>',
    ],
    "h4" => [
      "pattern" => "#### (.+)",
      "replace" => '<h4 id="${1}" style="margin-left: -1.5rem;"><a href="#">§</a> ${1} </h4>',
    ],
    "h5" => [
      "pattern" => "###### (.+)",
      "replace" => '<h5 id="${1}" style="margin-left: -1.5rem;"><a href="#">§</a> ${1} </h5>',
    ],
    "h6" => [
      "pattern" => "###### (.+)",
      "replace" => '<h6 id="${1}" style="margin-left: -1.5rem;"><a href="#">§</a> ${1} </h6>',
    ],
    // 
    "b" => [
      "pattern" => "",
      "replace" => "",
    ],
    "i" => [
      "pattern" => "",
      "replace" => "",
    ],
    // 链接
    "a" => [
      "pattern" => "",
      "replace" => "",
    ],
    // 图片
    "img" => [
      "pattern" => "",
      "replace" => "",
    ],
    "code" => [
      "pattern" => "",
      "replace" => "",
    ],
    // 代码块
    "pre" => [
      "pattern" => "",
      "replace" => "",
    ],
    // 无序列表
    "ul" => [
      "pattern" => "",
      "replace" => "",
    ],
    // 有序列表
    "ol" => [
      "pattern" => "",
      "replace" => "",
    ],
    "li" => [
      "pattern" => "",
      "replace" => "",
    ],
    "kbd" => [
      "pattern" => "",
      "replace" => "",
    ],
    // 分割线
    "hr" => [
      "pattern" => "",
      "replace" => "",
    ],
    // 表格
    "table" => [
      "pattern" => "",
      "replace" => "",
    ],
    // 引用
    "blockquote" => [
      "pattern" => "",
      "replace" => "",
    ],
    // 代办
    "todo" => [
      "pattern" => "(\s*)[-|*] \[ \] (.+)",
    ],
    // 已办
    "done" => [
      "pattern" => "(\s*)[-|*] \[x\] (.+)",
    ],
  ];
  public function setAlias(string $key, array $value)
  {
    $this->aliases[$key] = array_merge($this->aliases[$key], $value);
  }
  public function getAlias(string $key)
  {
    return $this->aliases[$key];
  }
  public function setAliases(array $value)
  {
    $this->aliases = array_merge($this->aliases, $value);
  }
  public function getAliases()
  {
    return $this->aliases;
  }
  private $alias = [
    // "/\n[]+\n/" => '<p> ${1} </p>',
    // 标题
    "/\n# (.+)\r/" => '<h1 id="${1}" style="margin-left: -1.5rem;"><a href="#">§</a> ${1} </h1>',
    "/\n## (.+)\r/" => '<h2 id="${1}" style="margin-left: -1.5rem;"><a href="#">§</a> ${1} </h2>',
    "/\n### (.+)\r/" => '<h3 id="${1}" style="margin-left: -1.5rem;"><a href="#">§</a> ${1} </h3>',
    "/\n#### (.+)\r/" => '<h4 id="${1}" style="margin-left: -1.5rem;"><a href="#">§</a> ${1} </h4>',
    "/\n##### (.+)\r/" => '<h5 id="${1}" style="margin-left: -1.5rem;"><a href="#">§</a> ${1} </h5>',
    "/\n###### (.+)\r/" => '<h6 id="${1}" style="margin-left: -1.5rem;"><a href="#">§</a> ${1} </h6>',

    // 引用
    "/\n> (.+)\r/" => '<blockquote> ${1} </blockquote>',
    // 代码块
    "/\n```(.+)\r\n/" => '<pre><code class="language-${1}">',

    "/\n```\r/" => '</code></pre>',
    // 链接
    "/\[(.+)\]\((.+)\)/" => '<a href="${2}"> ${1} </a>',
    // 图片
    "/!\[(.*)\]\((.+)\)/" => '<img src="${2}"> ${1} </img>',
    // 字体样式：加粗
    "/[^`]{1,}[*|_]{2,}([^*_]*)[*|_]{2,}/" => '<b> ${1} </b>',
    // 字体样式：斜体
    "/[^`]{1,}[*|_]([^*_]*)[*|_]/" => '<i> ${1} </i>',
    // 表格
    // 列表
    /**
     * 列表
     * @step 1
     * @step 2
     * @step 3
     */
    "/\n- (.+)\r/" => '<li> ${1} </li>',
    "/\r<li>(.+)<\/li>/" => '
<ul><li>${1}</li></ul>',

    // "/\n\<li\>(.+)\<\/li\>\r/" => '<ul><li> ${1} </li></ul>',
    //     "/\r\n- ([.|\\r|\\n]+)\r\n\r/is" => '
    // <ul> - ${1}</ul>

    // ',
    //     "/\n\r\n- /" => '

    // <ul>
    // - ',
    // "/\n\r\n- (.+)\r\n\r/s" => '<ul>- ${1} </ul>',
    //     '/(.+)\r\n\r/s' => '
    // </ul>
    // ',
    // "/\r\n\r/" => "123",

    // 其它
    "/\n---/" => '<hr/>',
    "/`{1}([^`]+)`{1}/" => '<kbd>${1}</kbd>',
  ];

  private $__operations = [];


  function parse(string $text = '')
  {
    if (empty($text))
      $text = $this->content;

    $exp = explode("\n", $this->content);
    // 遍历
    $i = 0;
    while ($i < sizeof($exp)) {
      $lineContent = $exp[$i];
      // 去除单行结尾换行符
      if (substr($lineContent, -strlen("\r")) == "\r") {
        $lineContent = substr($lineContent, 0, -strlen("\r"));
      }

      if ($lineContent == '') {
        $exp[$i] = array_merge($this->aliases['empty'], [
          'name' => 'empty',
          'text' => $lineContent,
          'content' => '',
        ]);
      } else {
        // 遍历
        foreach ($this->aliases as $alias => $rule) {
          if (empty($rule['pattern']))
            continue;
          $pattern = "/^" . $rule['pattern'] . "$/";
          // var_dump($lineContent);
          // var_dump(substr($lineContent, -strlen("\r")) == "\r");


          // 匹配
          if (preg_match($pattern, $lineContent, $matches)) {
            $exp[$i] = array_merge($rule, [
              'name' => $alias,
              'pattern' => $pattern,
              'text' => $lineContent,
              'content' => $matches[count($matches) - 1],
            ]);
          }
        }
      }

      $i++;
    }
    $this->tree = $exp;
    return $this;
  }

  function make($text, $options = [])
  {
    // dump([__METHOD__, $text, $options]);
    // dump([__METHOD__, $text, $options, $this->init_text($text), $this->split_text($text)]);
    // $arrays = $this->init_text(trim($text));
    // foreach ($arrays as $val) {
    $return = $this->to_html($this->init_text($text));
    // dump($return);
    // var_dump($return);
    // dump($return);
    // }
    return $return;
  }
  /**
   * 将原文中的水平制表符\t替换成空格,去除换行符\r:
   */
  function init_text($text)
  {
    // $text = str_replace(array("\t", "\r"), array('', ''), $text);
    return $text;
  }

  function split_text($text)
  {
    $text = str_replace(array("\t", "\r"), array('', ''), $text);
    $text_arrays = explode("\n\n", $text);
    return $text_arrays;
  }
  function to_html($text)
  {
    $text = "\n" . $text;
    foreach ($this->aliases as $pattern => $subject) {
      // dump($args);
      if (preg_match($pattern, $text)) {
        $text = preg_replace($pattern, $subject, $text);
      }
    }
    return $text;
  }
  function toHtml()
  {
  }
  function getMenu()
  {
  }
  /**
   * Summary of of
   * @param string $path 文件路径
   * @param array $option 局部配置
   * @return void
   */
  function of(string $path, array $option = [])
  {
    $this->setContent(file_get_contents($path));
    $this->setConfig($option);

    return $this;
  }

  function extract()
  {
  }
}
