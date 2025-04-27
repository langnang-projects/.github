<?php

namespace Illuminate\DevTool;

/**
 * 
 */
class DevTool
{
  function __construct() {}

  function _run()
  {
    $return = '<div style="position: fixed;bottom: 0;">';
    $return .= '<ul style="list-style: none;">';
    $return .= '<li style="display: inline-block;">元素</li>';
    $return .= '<li style="display: inline-block;">控制台</li>';
    $return .= '<li style="display: inline-block;">网络</li>';
    $return .= '</ul>';
    $return .= '</div>';
    // echo $return;
    // dump($this);
  }

  function make() {}
}
