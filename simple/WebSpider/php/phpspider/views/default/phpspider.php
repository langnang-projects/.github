<?php

$spider = new phpspider\core\phpspider($config);

var_dump($config);
/**
 * on_start($phpspider)
 * 爬虫初始化时调用, 用来指定一些爬取前的操作

 * @param $phpspider 爬虫对象
 */
$spider->on_start = function ($phpspider) {
    var_dump("on_start");
    // requests::set_header("Referer", "http://buluo.qq.com/p/index.html");
};
/**
 * on_status_code($status_code, $url, $content, $phpspider)
 * 判断当前网页是否被反爬虫了, 需要开发者实现
 * 
 * @param $status_code 当前网页的请求返回的HTTP状态码
 * @param $url 当前网页URL
 * @param $content 当前网页内容
 * @param $phpspider 爬虫对象
 * @return $content 返回处理后的网页内容，不处理当前页面请返回false
 */
$spider->on_status_code = function ($status_code, $url, $content, $phpspider) {
    var_dump("on_status_code", $url);
    // 如果状态码为429，说明对方网站设置了不让同一个客户端同时请求太多次
    if ($status_code == '429') {
        // 将url插入待爬的队列中,等待再次爬取
        $phpspider->add_url($url);
        // 当前页先不处理了
        return false;
    }
    // 不拦截的状态码这里记得要返回，否则后面内容就都空了
    return $content;
};
/**
 * is_anti_spider($url, $content, $phpspider)
 * 判断当前网页是否被反爬虫了, 需要开发者实现
 * 
 * @param $url 当前网页的url
 * @param $content 当前网页内容
 * @param $phpspider 爬虫对象
 * @return 如果被反爬虫了, 返回true, 否则返回false
 */
$spider->is_anti_spider = function ($url, $content, $phpspider) {
    var_dump("is_anti_spider", $url);
    // $content中包含"404页面不存在"字符串
    if (strpos($content, "404页面不存在") !== false) {
        // 如果使用了代理IP，IP切换需要时间，这里可以添加到队列等下次换了IP再抓取
        // $phpspider->add_url($url);
        return true; // 告诉框架网页被反爬虫了，不要继续处理它
    }
    // 当前页面没有被反爬虫，可以继续处理
    return false;
};
/**
 * on_download_page($page, $phpspider)
 * 在一个网页下载完成之后调用. 主要用来对下载的网页进行处理.
 * 
 * @param $page 当前下载的网页页面的对象
 * @param $phpspider 爬虫对象
 * @return 返回处理后的网页内容
 * 
 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象
 */
$spider->on_download_page = function ($page, $phpspider) use ($config) {
    var_dump("on_download_page", $page);
    // dump($phpspider);
    // dump($page);
    $url = preg_replace("/:|\//", "_", $page['url']);
    $url = preg_replace("/_+/", "_", $url);
    if (!file_exists(__DIR__ . '/data')) {
        mkdir(__DIR__ . '/data');
    }
    if (!file_exists(__DIR__ . '/data/log')) {
        mkdir(__DIR__ . '/data/log');
    }
    if (!file_exists(__DIR__ . '/data/log/' . $config['slug'])) {
        mkdir(__DIR__ . '/data/log/' . $config['slug']);
    }
    file_put_contents(__DIR__ . '/data/log/' . $config['slug'] . '/' . $url . ".html", $page['raw']);
    // dump($url);
    // exit;
    // $page_html = "<div id=\"comment-pages\"><span>5</span></div>";
    // $index = strpos($page['row'], "</body>");
    // $page['raw'] = substr($page['raw'], 0, $index) . $page_html . substr($page['raw'], $index);
    return $page;
};
/**
 * on_download_attached_page($content, $phpspider)
 * 在一个网页下载完成之后调用. 主要用来对下载的网页进行处理.
 * 
 * @param $content 当前下载的网页内容
 * @param $phpspider 爬虫对象
 * @return 返回处理后的网页内容
 */
$spider->on_download_attached_page = function ($content, $phpspider) {

    var_dump('on_download_attached_page');
    // dump($content);
    // $content = trim($content);
    // $content = ltrim($content, "[");
    // $content = rtrim($content, "]");
    // $content = json_decode($content, true);
    // exit;
    return $content;
};
/**
 * on_fetch_url($url, $phpspider)
 * 在一个网页获取到URL之后调用. 主要用来对获取到的URL进行处理.
 * 
 * @param $url 当前获取到的URL
 * @param $phpspider 爬虫对象
 * @return 返回处理后的URL，为false则此URL不入采集队列
 */
$spider->on_fetch_url = function ($url, $phpspider) {
    // var_dump("on_fetch_url", $url);
    // if (strpos($url, "#filter") !== false) {
    //   return false;
    // }
    return $url;
};
/**
 * on_scan_page($page, $content, $phpspider)
 * 在爬取到入口url的内容之后, 添加新的url到待爬队列之前调用. 主要用来发现新的待爬url, 并且能给新发现的url附加数据（点此查看“url附加数据”实例解析）.
 * 
 * @param $page 当前下载的网页页面的对象
 * @param $content 当前网页内容
 * @param $phpspider 当前爬虫对象
 * @return 返回false表示不需要再从此网页中发现待爬url

 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象

 * 此函数中通过调用$phpspider->add_url($url, $options)函数来添加新的url到待爬队列。
 */
$spider->on_scan_page = function ($page, $content, $phpspider) use ($config) {
    var_dump(["on_scan_page", $page['url']]);
    if (isset($config['callback'])) $config['callback']($phpspider);
    // return false;
};
/**
 * on_list_page($page, $content, $phpspider)
 * 在爬取到入口url的内容之后, 添加新的url到待爬队列之前调用. 主要用来发现新的待爬url, 并且能给新发现的url附加数据（点此查看“url附加数据”实例解析）.

 * @param  $page 当前下载的网页页面的对象
 * @param  $content 当前网页内容
 * @param  $phpspider 当前爬虫对象
 * @return 返回false表示不需要再从此网页中发现待爬url

 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象

 * 此函数中通过调用$phpspider->add_url($url, $options)函数来添加新的url到待爬队列。
 */
$spider->on_list_page = function ($page, $content, $phpspider) {
    var_dump(["on_list_page", $page['url']]);
    if (isset($config['callback'])) $config['callback']($phpspider);
    // return false;
};
/**
 * on_content_page($page, $content, $phpspider)
 * 在爬取到入口url的内容之后, 添加新的url到待爬队列之前调用. 主要用来发现新的待爬url, 并且能给新发现的url附加数据（点此查看“url附加数据”实例解析）.

 * @param $page 当前下载的网页页面的对象
 * @param $content 当前网页内容
 * @param $phpspider 当前爬虫对象
 * @return 返回false表示不需要再从此网页中发现待爬url

 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象

 * 此函数中通过调用$phpspider->add_url($url, $options)函数来添加新的url到待爬队列。
 */
$spider->on_content_page = function ($page, $content, $phpspider) {
    var_dump(["on_content_page", $page['url']]);
    if (isset($config['callback'])) $config['callback']($phpspider);
    // return false;
};
/**
 * on_handle_img($fieldname, $img)
 * 在抽取到field内容之后调用, 对其中包含的img标签进行回调处理

 * @param $fieldname 当前field的name. 注意: 子field的name会带着父field的name, 通过.连接.
 * @param $img 整个img标签的内容
 * @return 返回处理后的img标签的内容

 * 很多网站对图片作了延迟加载, 这时候就需要在这个函数里面来处理
 */
$spider->on_handle_img = function ($fieldname, $img) {
    // $regex = '/src="(https?:\/\/.*?)"/i';
    // preg_match($regex, $img, $rs);
    // if (!$rs) {
    //   return $img;
    // }
    // $url = $rs[1];
    // if ($url == "http://x.autoimg.cn/club/lazyload.png") {
    //   $regex2 = '/src9="(https?:\/\/.*?)"/i';
    //   preg_match($regex, $img, $rs);
    //   // 替换成真是图片url
    //   if (!$rs) {
    //     $new_url = $rs[1];
    //     $img = str_replace($url, $new_url);
    //   }
    // }
    return $img;
};
/**
 * on_extract_field($fieldname, $data, $page)
 * 当一个field的内容被抽取到后进行的回调, 在此回调中可以对网页中抽取的内容作进一步处理

 * @param $fieldname 当前field的name. 注意: 子field的name会带着父field的name, 通过.连接.
 * @param $data 当前field抽取到的数据. 如果该field是repeated, data为数组类型, 否则是String
 * @param $page 当前下载的网页页面的对象
 * @return 返回处理后的数据, 注意数据类型需要跟传进来的$data类型匹配

 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象
 */
$spider->on_extract_field = function ($fieldname, $data, $page) {
    // dump("on_extract_field", $page['url'] . ", $fieldname);
    // if ($fieldname == 'gender') {
    //   // data中包含"icon-profile-male"，说明当前知乎用户是男性
    //   if (strpos($data, "icon-profile-male") !== false) {
    //     return "男";
    //   }
    //   // data中包含"icon-profile-female"，说明当前知乎用户是女性
    //   elseif (strpos($data, "icon-profile-female") !== false) {
    //     return "女";
    //   } else {
    //     return "未知";
    //   }
    // }
    return $data;
};
/**
 * on_extract_page($page, $data)
 * 在一个网页的所有field抽取完成之后, 可能需要对field进一步处理, 以发布到自己的网站

 * @param $page 当前下载的网页页面的对象
 * @param $data 当前网页抽取出来的所有field的数据
 * @return 返回处理后的数据, 注意数据类型需要跟传进来的$data类型匹配

 * @param $page['url'] 当前网页的URL
 * @param $page['raw'] 当前网页的内容
 * @param $page['request'] 当前网页的请求对象
 */
$spider->on_extract_page = function ($page, $data) use ($config) {
    var_dump("on_extract_page", $page['url']);
    // $title = "[{$data['time']}]" . $data['title'];
    // $data['title'] = $title;
    if (isset($config['export']) && $config['export']['type'] == 'csv') {
        foreach ($data as $key => $value) {
            $data[$key] = json_encode($value, JSON_UNESCAPED_UNICODE);
        }
    }
    $return = [
        "cid" => 1,
        "url" => $page['url'],
        "text" => json_encode($data, JSON_UNESCAPED_UNICODE),
        "updated_at" => date('Y-m-d H:i:s', time()),
    ];
    // $data['cid'] = 1;
    // $data['url'] = $page['url'];
    if ($config['max_fields'] !== 0) {
        var_dump($return);
    }
    // exit;
    return $return;
    // 返回false不处理，当前页面的字段不入数据库直接过滤
    // 比如采集电影网站，标题匹配到“预告片”这三个字就过滤
    //if (strpos($data['title'], "预告片") !== false)
    //{
    //    return false;
    //}
};
