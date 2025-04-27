<?php

namespace App\Http\Controllers;

use App\Models\Model;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Support\Helpers\PhpSpiderHelper;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Arr;

/**
 * @OA\Info(title="My First API", version="0.1")
 */
/**
 * @OA\Get(
 *     path="/projects",
 *     @OA\Response(response="200", description="Display a listing of projects.")
 * )
 */
class TempController extends ApiController
{
    use \App\Traits\Controller\HasView;

    use BaseResponse, BaseRequest, BaseClauses, BaseDecouple, BaseCall, BaseImportTree, BaseCron, BaseGetViewShared;

    /**
     * 函数组对象
     */
    protected $keyMap = [
        'mid' => 'upsert_meta_item',
        'meta' => 'upsert_meta_item',
        'mids' => 'upsert_meta_list',
        'metas' => "upsert_meta_list",
        'cid' => 'upsert_content_item',
        'content' => 'upsert_content_item',
        'cids' => 'upsert_content_list',
        'contents' => "upsert_content_list",
        'lid' => 'upsert_link_item',
        'link' => 'upsert_link_item',
        'lids' => 'upsert_link_list',
        'links' => "upsert_link_list",
        'relationships' => '',
        'coid' => 'upsert_comment_item',
        'comment' => 'upsert_comment_item',
        'coids' => 'upsert_comment_list',
        'comments' => 'upsert_comment_list',
        'uid' => 'upsert_user_item',
        'user' => 'upsert_user_item',
        'uids' => 'upsert_user_list',
        'users' => 'upsert_user_list',
        'id' => 'upsert_field_item',
        'field' => 'upsert_field_item',
        'ids' => 'upsert_field_list',
        'fields' => 'upsert_field_list',
    ];
    /**
     * 导入映射关系
     * @var $key
     * @var $value [$func, $type in [primaryKey,object,array], $default]
     * @var array
     */
    protected $importMapping = [
        "meta" => ["upsert_meta_item", "object",],
        "metas" => ["upsert_meta_list", "array",],
        "tag" => ["upsert_meta_item", "object", ["type" => "tag"]],
        "tags" => ["upsert_meta_list", "array", ["type" => "tag"]],
        "category" => ["upsert_meta_item", "object", ["type" => "category"]],
        "categories" => ["upsert_meta_list", "array", ["type" => "category"]],
        "collection" => ["upsert_meta_item", "object", ["type" => "collection"]],
        "collections" => ["upsert_meta_list", "array", ["type" => "collection"]],

        "link",
        "links",

        "content" => ["upsert_content_item", "object"],
        "contents" => ["upsert_content_list", "array"],
        "post" => ["upsert_content_item", "object", ["type" => "post"]],
        "posts" => ["upsert_content_list", "array", ["type" => "post"]],
        "template" => ["upsert_content_item", "object", ["type" => "post"]],
        "templates" => ["upsert_content_list", "array", ["type" => "template"]],

        "field" => ["upsert_field_item", "object"],
        "fields" => ["upsert_field_list", "array"],

        "comment",
        "comments",

        "user",
        "users",

        "option",
        "options",

        "relationship" => ['upsert_relationship_item', 'object'],
        "relationships" => ['upsert_relationship_list', 'array'],
    ];
    protected $extendImportMapping = [];

    public $prefix;
    protected $_logs = [];

    public function index()
    {
        return view('welcome');
    }
}

trait BaseResponse
{

}

trait BaseRequest
{
}

/**
 * 生成语句
 */
trait BaseClauses
{

}

/**
 * 解耦
 */
trait BaseDecouple
{

}

trait BaseCall
{

}


trait BaseSpiderSource
{
    function spider_source_search()
    {
    }

    function spider_source_discover()
    {
    }

    function spider_source_category()
    {
    }

    function spider_source_detail()
    {
    }

    function spider_source_item()
    {
    }

    function spider_source_download()
    {
    }
}


trait BaseImportTree
{
    public function import_tree(Request $request, $global_default = [])
    {
        // var_dump($global_default);
        // TODO 集中其它方法至此方法
        try {
            $_logs = [__METHOD__, $request->all()];
            // dump($_logs);
            $mapping = $this->getImportMapping();
            // dump(__METHOD__);
            $return = [];

            foreach ($mapping as $key => $funcs) {
                $func = '';
                $type = 'object';
                $default = [];
                if (is_string($funcs))
                    $func = $funcs;
                if (is_array($funcs)) {
                    $func = $funcs[0];
                    $type = $funcs[1] ?? $type;
                    $default = $funcs[2] ?? $default;
                }
                if ($request->filled($key)) {
                    // var_dump($key);
                    // var_dump($func);
                    // var_dump($type);
                    // var_dump($default);
                    $data = new Request();
                    switch ($type) {
                        // 主键
                        case 'primaryKey':
                            $request->merge($default);
                            $data = new Request(array_merge($global_default, $request->all()));
                            $return = method_exists($this, $func) ? $this->getReturn($this->{$func}($data)) : $return;
                            if ($return instanceof Exception)
                                throw $return;
                            break;
                        case 'object':
                            $data = $request->input($key, []);
                            // var_dump($data);
                            $data = new Request(array_merge($global_default, $data, $default));
                            $return[$key] = method_exists($this, $func) ? $this->getReturn($this->{$func}($data)) : $return;
                            if ($return[$key] instanceof Exception)
                                throw $return[$key];
                            break;
                        case 'array':
                            $data = $request->input($key, []);
                            $data = new Request([
                                "data" => array_map(function ($item) use ($default, $global_default) {
                                    return array_merge($global_default, $item, $default);
                                }, $data)
                            ]);
                            // var_dump($global_default);
                            // var_dump($data->input('data'));
                            $return[$key] = method_exists($this, $func) ? $this->getReturn($this->{$func}($data)) : $return;
                            if ($return[$key] instanceof Exception)
                                throw $return[$key];
                            $return[$key] = $return[$key]['data'];
                            break;
                        default:
                            break;
                    }
                }
            }
            return $this->success($return);
            // if ($request->hasAny(['mid', 'mids', 'meta', 'metas'])) {
            // }
            // if ($request->hasAny(['cid', 'cids', 'content', 'contents'])) {
            //   $this->import_content_tree($request);
            // }
            if ($request->hasAny(['id', 'ids', 'field', 'fields'])) {
            }
            if ($request->filled('mid')) {
                array_push($_logs, 'request filled mid.');
                $return = array_merge($return, $this->getReturn($this->upsert_meta_item($request)));
            } elseif ($request->filled('cid')) {
                if ($request->filled('id')) {
                    // Field
                    $return = array_merge($return, $this->getReturn($this->upsert_field_item($request)));
                } else {
                    // Content
                    $return = array_merge($return, $this->getReturn($this->upsert_content_item($request)));
                }
            } elseif ($request->filled('lid')) {
                array_push($_logs, 'request filled lid.');
                $return = $request->input('lid');
            }
            if ($request->filled('relationships')) {
                array_push($_logs, 'request filled relationships.');
                $return['relationships'] = [];
            }
            if ($request->filled('meta')) {
                array_push($_logs, 'request filled meta.');
                $return['meta'] = $this->getReturn($this->upsert_meta_item(new Request($request->input('meta'))));
            }
            if ($request->filled('metas')) {
                array_push($_logs, 'request filled metas.');
                $return['metas'] = $this->getReturn($this->upsert_meta_list(new Request(["data" => $request->input('metas')])))['data'];
            }
            if ($request->filled('content')) {
                array_push($_logs, 'request filled key(content).');
                $return['content'] = $this->getReturn($this->upsert_content_item(new Request($request->input('content'))));
            }
            if ($request->filled('contents')) {
                $upserted_content_list = $this->getReturn($this->upsert_content_list(new Request(["data" => $request->input('contents')])));
                // dump($_logs);
                // dump($upserted_content_list);
                if ($upserted_content_list instanceof Exception)
                    throw $upserted_content_list;
                array_push($_logs, [
                    'request filled key(contents).',
                    '$this->upsert_content_list',
                    $upserted_content_list['_logs'],
                ]);
                // dump($_logs);
                $return['contents'] = $upserted_content_list['data'];
                // if (isset($return['mid'])) {
                //   $relationships = array_map(function ($content) use ($return) {
                //     return [
                //       $this->prefix . '_cid' => $content['cid'],
                //       $this->prefix . '_mid' => $return['mid'],
                //     ];
                //   }, $return['contents']);
                //   $this->RelationshipModel::insertOrIgnore($relationships);
                // }
                // if (isset($return['lid'])) {
                // }
            }
            if ($request->filled('link')) {
                array_push($_logs, 'request filled link.');
                $return['link'] = [];
            }
            if ($request->filled('links')) {
                array_push($_logs, 'request filled links.');
                $return['links'] = [];
            }
            // dump($_logs);
            // artisan_dump($_logs);
            return $this->success($return);
        } catch (Exception $e) {
            // var_dump($_logs);

            $this->error($e);
        }
    }

    public function import_meta_tree()
    {
    }

    public function import_content_tree(Request $request)
    {
        try {
            dump(__METHOD__, $request);
        } catch (Exception $e) {
            $this->error($e);
        }
    }

    public function import_field_tree()
    {
    }
}

trait BaseCron
{
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function cron(Request $request)
    {
    }
}

trait BaseGetViewShared
{
    function get_view_categories(Request $request)
    {
        return $this->getReturn($this->select_meta_tree(new Request([
            'parent' => 0,
            'type' => 'category'
        ])));
    }

    function get_view_tags(Request $request)
    {
        return $this->getReturn($this->select_meta_list(new Request([
            'type' => 'tag',
            'page' => 1,
            'page_size' => PHP_INT_MAX,
        ])));
    }

    function get_view_latest_contents(Request $request)
    {
        return $this->getReturn($this->select_content_list(new Request([
            'type' => 'post',
            '$order' => ['updated_at'],
            'page' => 1,
            'page_size' => 10
        ])));
    }

    function get_view_toplist_contents(Request $request)
    {
        return $this->getReturn($this->select_content_list(new Request([
            'type' => 'post',
            '$order' => ['views'],
            'page' => 1,
            'page_size' => 10
        ])));
    }
    function get_view_options(Request $request)
    {
        $result = $this->OptionModel::whereIn('name', $request->input('names', []))->get();
        $result = $result->map(function ($item) {
            return $item->toArray();
        });
        return $result->pluck('value', 'name');
    }
}
