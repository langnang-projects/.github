<?php

namespace Illuminate\Usage;

/**
 * 
 */
class Usage
{
  function _autoload() {}
  function print()
  {
    $return = "<pre style='background-color: #18171B;color: #FF8400;margin: 0;position: fixed;bottom: .5rem;right: .5rem;'>"
      . "<details open>"
      . "<summary><font style='float: left;'> CPU: </font></summary>"
      . "<ul>";
    $rusage = $this->cpu();
    foreach (
      [
        "ru_oublock" => "块输出操作数",
        "ru_inblock" => "块输入操作数",
        "ru_msgsnd" => "发送的 IPC 消息数",
        "ru_msgrcv" => "接收的 IPC 消息数",
        "ru_maxrss" => "最大常驻集大小",
        "ru_ixrss" => "整数类型的共享内存大小",
        "ru_idrss" => "整数类型的非共享内存大小",
        "ru_minflt" => "页面回收次数（软分页错误）",
        "ru_majflt" => "页面错误次数（硬分页错误）",
        "ru_nsignals" => "接收到的信号数",
        "ru_nvcsw" => "主动上下文切换",
        "ru_nivcsw" => "被动上下文切换",
        "ru_nswap" => "交换次数",
        "ru_utime.tv_usec" => "用户使用时间（微秒）",
        "ru_utime.tv_sec" => "用户使用时间（秒）",
        "ru_stime.tv_usec" => "系统使用时间（微秒）",
        "ru_stime.tv_sec" => "系统使用时间（秒）",
      ] as $key => $desc
    ) {
      if (isset($rusage[$key])) $return .= "<li>$key: <font style='color: #56DB3A;'>" . $rusage[$key] . "</font> </li>";
    }
    $return .= "</ul>"
      . "</details>"
      . "<details open>"
      . "<summary><font style='float: left;'> Memory: </font></summary>"
      . "<ul>"
      . "<li>Used: <font style='color: #56DB3A;'>" . $this->memory() . "</font> bytes</li>"
      . "<li>Peak: <font style='color: #56DB3A;'>" . $this->peak_memory() . "</font> bytes</li>"
      . "</ul>"
      . "</details> "
      . "</pre>";
    echo $return;
  }
  function cpu()
  {
    return getrusage();
  }
  /**
   * 使用内存 (bytes)
   */
  function memory()
  {
    return memory_get_usage();
  }
  /**
   * 峰值内存 (bytes)
   */
  function peak_memory()
  {
    return memory_get_peak_usage();
  }

  function _run()
  {
    if (config('this.print')) $this->print();
  }
}
