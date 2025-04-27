<?php

namespace Modules\WebHunt\Http\Controllers;

use App\Illuminate\PhpSpider\PhpSpider;
use App\Illuminate\PhpSpider\Selector;
use Http;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\Paginator;

class WebHuntController extends \App\Http\Controllers\Controller
{
    protected $mergeModels = [
    ];
    public function view_index($id = null)
    {
        $return = [
            'posts' => \Modules\WebHunt\Models\WebHunt::paginate(15),
        ];
        // dump($return);
        return $this->view('index', $return);
    }
    public function view_content($id)
    {

        $page = request()->input('page', 1);
        [$id, $group] = explode('-', $id);
        // var_dump($idOrSlug);
        var_dump([$id, $group]);
        $content = \Modules\WebHunt\Models\WebHunt::find($id);
        // var_dump($content);

        $config = $content->text;
        $group = $content->text['groups'][$group];
        var_dump([$id, $group]);
        $return = [
            'content' => $content,
            'content_group' => $group,
            'hunt_contents' => [],
        ];
        $url = (\Str::endsWith($config['url'], '/') ? $config['url'] . '/' : $config['url']) . (\Str::startsWith($group['additional_url'], '/', ) ? substr($group['additional_url'], 1) : $group['additional_url']);


        $url = preg_replace(['{$page}'], [$page], $url);
        // $url = preg_replace([], [], $url);
        // $urlSlug = Str::
        var_dump($url);

        $response = Http::get($url);
        $spider = new PhpSpider([]);

        var_dump($response->body());

        $html = $response->body();

        $fields = $spider->get_fields($config[$group['next']]['fields'], $html, $url, []);
        $return['hunt_contents'] = new \Illuminate\Pagination\Paginator($fields['items'], 17, $page, $fields);
        var_dump($fields);
        var_dump($return['hunt_contents']->getOptions());
        // $spiderConfig = $content->text;
        // $spiderConfig['name'] = $content->title;
        // $spiderConfig['db_config'] = [
        //     'host' => env('DB_HOST', '127.0.0.1'),
        //     'port' => env('DB_PORT', 3306),
        //     'user' => env('DB_USERNAME', 'root'),
        //     'pass' => env('DB_PASSWORD', 'root'),
        //     'name' => env('DB_DATABASE', 'demo'),
        // ];
        // // dump($spiderConfig);
        // // dump(parse_url($content->slug));

        // $spider = new \App\Illuminate\PhpSpider\phpspider($spiderConfig);
        // var_dump($spiderConfig);
        // $spider->on_download_page = function ($page, $phpspider) {
        //     var_dump(['on_download_page', $page]);
        //     // $page_html = "<div id=\"comment-pages\"><span>5</span></div>";
        //     // $index = strpos($page['row'], "</body>");
        //     // $page['raw'] = substr($page['raw'], 0, $index) . $page_html . substr($page['raw'], $index);
        //     return $page;
        // };
        // $spider->on_download_attached_page = function ($content, $phpspider) {
        //     var_dump(['on_download_attached_page', $content]);
        //     // $content = trim($content);
        //     // $content = ltrim($content, "[");
        //     // $content = rtrim($content, "]");
        //     // $content = json_decode($content, true);
        //     return $content;
        // };
        // $spider->on_fetch_url = function ($url, $phpspider) {
        //     var_dump(['on_fetch_url', $url]);
        //     // if (strpos($url, "#filter") !== false) {
        //     //     return false;
        //     // }
        //     return $url;
        // };
        // $spider->on_scan_page = function ($page, $content, $phpspider) {
        //     var_dump(['on_scan_page', $page]);
        //     // $array = json_decode($page['raw'], true);
        //     // foreach ($array as $v) {
        //     //     $lastid = $v['id'];
        //     //     // 生成一个新的url
        //     //     $url = $page['url'] . $lastid;
        //     //     // 将新的url插入待爬的队列中
        //     //     $phpspider->add_url($url);
        //     // }
        //     // 通知爬虫不再从当前网页中发现待爬url
        //     // return false;
        // };
        // $spider->on_list_page = function ($page, $content, $phpspider) {
        //     var_dump(['on_list_page', $page]);
        //     // $array = json_decode($page['raw'], true);
        //     // foreach ($array as $v) {
        //     //     $lastid = $v['id'];
        //     //     // 生成一个新的url
        //     //     $url = $page['url'] . $lastid;
        //     //     // 将新的url插入待爬的队列中
        //     //     $phpspider->add_url($url);
        //     // }
        //     // 通知爬虫不再从当前网页中发现待爬url
        //     return false;
        // };
        // $spider->on_content_page = function ($page, $content, $phpspider) {
        //     var_dump(['on_content_page', $page]);
        //     // $array = json_decode($page['raw'], true);
        //     // foreach ($array as $v) {
        //     //     $lastid = $v['id'];
        //     //     // 生成一个新的url
        //     //     $url = $page['url'] . $lastid;
        //     //     // 将新的url插入待爬的队列中
        //     //     $phpspider->add_url($url);
        //     // }
        //     // 通知爬虫不再从当前网页中发现待爬url
        //     return false;
        // };
        // $spider->on_extract_field = function ($fieldname, $data, $page) {
        //     var_dump(['on_extract_field', $data]);
        //     // if ($fieldname == 'gender') {
        //     //     // data中包含"icon-profile-male"，说明当前知乎用户是男性
        //     //     if (strpos($data, "icon-profile-male") !== false) {
        //     //         return "男";
        //     //     }
        //     //     // data中包含"icon-profile-female"，说明当前知乎用户是女性
        //     //     elseif (strpos($data, "icon-profile-female") !== false) {
        //     //         return "女";
        //     //     } else {
        //     //         return "未知";
        //     //     }
        //     // }
        //     return $data;
        // };
        // $spider->on_extract_page = function ($page, $data) {
        //     var_dump(['on_extract_page', $data]);
        //     // $title = "[{$data['time']}]" . $data['title'];
        //     // $data['title'] = $title;
        //     // return $data;
        //     // 返回false不处理，当前页面的字段不入数据库直接过滤
        //     // 比如采集电影网站，标题匹配到“预告片”这三个字就过滤
        //     //if (strpos($data['title'], "预告片") !== false)
        //     //{
        //     //    return false;
        //     //}
        // };
        // $spider->start();


        return $this->view('content', $return);
    }
}
