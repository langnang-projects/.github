<?php

/**
 * 
 */

return array(
  "name" => "OneCrawler",
  "password" => "onecrawler",
  "interval" => 1440000,
  "sources" => [
    ["key" => "video",  "name" => "影视", "icon" => "glyphicon glyphicon-facetime-video", "status" => 'public'],
    ["key" => "novel",  "name" => "小说", "icon" => "glyphicon glyphicon-book", "status" => 'public'],
    ["key" => "audio",  "name" => "音频", "icon" => "glyphicon glyphicon-music", "status" => 'public'],
    ["key" => "image",  "name" => "图像", "icon" => "glyphicon glyphicon-picture", "status" => 'public'],
    ["key" => "news", "name" => "资讯", "icon" => "glyphicon glyphicon-envelope", "status" => 'protected'],
    ["key" => "thunder", "name" => "迅雷", "icon" => "glyphicon glyphicon-save", "status" => 'protected'],
  ]
);
