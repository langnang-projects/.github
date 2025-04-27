<?php


class SiteSource
{
  public $name;
  public $url;
  public $group;
  public $comment;

  public $search;
  public $discover;
  public $detail;
  public $category;
  public $content;
  function __construct($arg)
  {
    $this->search = new SiteSourceItemSearch($arg['search']);
    $this->discover = new SiteSourceItemDiscover($arg['discover']);
    $this->detail = new SiteSourceItemDetail($arg['info']);
    $this->category = new SiteSourceItemCategory($arg['category']);
    $this->content = new SiteSourceItemContent($arg['content']);
  }
}
/**
 * 搜索
 */
class SiteSourceItemSearch
{
  public $url;
  public $checkKeyWord;
}
/**
 * 发现
 */
class SiteSourceItemDiscover
{
}
/**
 * 详情
 */
class SiteSourceItemDetail
{
}
/**
 * 目录
 */
class SiteSourceItemCategory
{
}
/**
 * 正文
 */
class SiteSourceItemContent
{
}
