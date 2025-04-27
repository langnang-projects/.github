<?php

namespace App\Http\Controllers;

use App\Models\Model;
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
class ApiController extends \Illuminate\Routing\Controller
{
    use \App\Traits\Controller\HasModels,
        \App\Traits\Controller\HasModule,
        \App\Traits\Controller\HasLogs,
        \App\Traits\Controller\HasArtisan;

    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests,
        \Illuminate\Foundation\Bus\DispatchesJobs,
        \Illuminate\Foundation\Validation\ValidatesRequests;

    // use \App\Traits\Modules\BaseTrait;
    use \App\Traits\Controller\Crud\BaseCrudTrait,
        \App\Traits\Controller\Crud\MetaCrudTrait,
        \App\Traits\Controller\Crud\ContentCrudTrait,
        \App\Traits\Controller\Crud\LinkCrudTrait,
        \App\Traits\Controller\Crud\FieldCrudTrait,
        \App\Traits\Controller\Crud\RelationshipCrudTrait;


    protected $BaseModel;
    protected $MetaModel = \App\Models\Meta::class;
    protected $ContentModel = \App\Models\Content::class;
    protected $FieldModel = \App\Models\Field::class;
    protected $CommentModel = \App\Models\Comment::class;
    protected $LinkModel = \App\Models\Link::class;
    protected $RuleModel = \App\Models\Rule::class;
    protected $RelationshipModel = \App\Models\Relationship::class;
    protected $UserModel = \App\Models\User::class;
    protected $OptionModel = \App\Models\Option::class;
    protected $LogModel = \App\Models\Log::class;

    public function __construct()
    {
        $this->setModels();
    }

    public function from_admin()
    {
        return preg_match('/^admin*/', request()->route()->getPrefix());
    }
    public function getOriginalData($value)
    {
        $return = [];
        if ($value instanceof \Illuminate\Http\JsonResponse) {
            $return = ($value->getData(true))['data'];
        }
        return $return;
    }
    /**
     * 导入映射
     *
     * @return void
     */
    function getImportMapping()
    {
        return array_merge($this->importMapping, $this->extendImportMapping);
    }

    /**
     * 检测API路由
     */
    public function isApiRoute()
    {
        $header = request()->header();
        // dump(request()->server('PHP_SELF'));
        // dump(request()->is("cli/*"));
        // dump(Route::currnet());
        if (request()->server('PHP_SELF') === 'artisan')
            return false;
        // $isFromOpenAPI=substr($header['refer']);
        return Route::current()->computedMiddleware[0] === 'api';
    }

    public function isArtisanCli()
    {
        return request()->server('PHP_SELF') === 'artisan';
    }

    public function getKeyMap($key = null)
    {
        $return = [];
        $parent = get_parent_class($this);
        // 调用的控制器非当前控制器
        // 且
        //
        if (__CLASS__ !== get_class($this) && get_class($this) !== $parent) {
            $return = array_merge($return, (new $parent)->getKeyMap());
        }
        $return = array_merge($return, $this->keyMap);
        return $return;
    }

    public function getModelPrefix()
    {
    }

    /**
     * @description 检测类中是否定义 Model
     * @param string $name
     * @return bool|string
     * @throws \Exception
     */
    public function issetModel(string $name)
    {
        switch ($name) {
            case 'base':
            case $this->BaseModel:
                if (!$this->BaseModel) {
                    throw new \Exception(Lang::get('validation.unset_model.base'));
                }

                return $this->BaseModel;
                break;
            case 'meta':
            case $this->MetaModel:
                if (!$this->MetaModel) {
                    throw new \Exception(Lang::get('validation.unset_model.meta'));
                }

                return $this->MetaModel;
                break;
            case 'content':
            case $this->ContentModel:
                if (!$this->ContentModel) {
                    throw new \Exception(Lang::get('validation.unset_model.content'));
                }

                return $this->ContentModel;
                break;
            case 'link':
            case $this->LinkModel:
                if (!$this->LinkModel) {
                    throw new \Exception(Lang::get('validation.unset_model.link'));
                }

                return $this->LinkModel;
                break;
            case 'relationship':
            case $this->RelationshipModel:
                if (!$this->RelationshipModel) {
                    throw new \Exception(Lang::get('validation.unset_model.relationship'));
                }

                return $this->RelationshipModel;
                break;
            case 'field':
            case $this->FieldModel:
                if (!$this->FieldModel) {
                    throw new \Exception(Lang::get('validation.unset_model.relationship'));
                }

                return $this->FieldModel;
                break;
            default:
                break;
        }
        return true;
    }

    /**
     * @description 检测类中是否使用 Trait
     * @param string $name
     * @return bool
     * @throws \Exception
     */
    public function isuseCrudTrait(string $name)
    {
        $traits = class_uses($this);
        switch ($name) {
            case 'base':
                if (!in_array('App\Traits\Crud\BaseCrudTrait', $traits)) {
                    throw new \Exception(Lang::get('validation.unset_model.base'));
                }

                break;
            case 'meta':
                if (!in_array('App\Traits\Crud\MetaCrudTrait', $traits)) {
                    throw new \Exception(Lang::get('validation.unset_model.meta'));
                }

                break;
            case 'content':
                if (!in_array('App\Traits\Crud\ContentCrudTrait', $traits)) {
                    throw new \Exception(Lang::get('validation.unset_model.content'));
                }

                break;
            case 'link':
                if (!in_array('App\Traits\Crud\LinkCrudTrait', $traits)) {
                    throw new \Exception(Lang::get('validation.unset_model.link'));
                }

                break;
            default:
                break;
        }
        return true;
    }
    public function success($data = [], $message = '成功')
    {
        // var_dump(debug_backtrace());
        // Log::info('[' . request()->method() . '] ' . request()->fullUrl(), [
        //   // "attributes" => request()->attributes(),
        //   "request" => request()->all(),
        //   "query" => request()->query(),
        //   "server" => request()->server(),
        //   // "files" => request()->files() ?? [],
        //   "cookies" => request()->cookie(),
        //   "headers" => request()->header(),
        //   'response' => $data,
        //   'debug' => array_map(function ($item) {
        //     return ($item['class'] ?? '') . '::' . $item['function'] . '->' . $item['line'];
        //   }, debug_backtrace()),
        // ]);
        // Log::channel('mysql')->info();
        if ($this->isApiRoute()) {
            $return = [
                'status' => 200,
                'message' => $message,
                'data' => $data,
                'logs' => $this->getLogs()
            ];
            // if ($data instanceof \Illuminate\Pagination\Paginator || $data instanceof \Illuminate\Contracts\Pagination\Paginator) {
            //     $return = array_merge($return, $data->toArray());
            //     unset($return['first_page_url']);
            //     unset($return['next_page_url']);
            //     unset($return['path']);
            //     unset($return['prev_page_url']);
            //     unset($return['last_page_url']);
            //     unset($return['links']);
            //     unset($return['prev_page_url']);
            // }
            \Log::channel('mysql')->info(request()->getPathInfo(), [
                // "route" => $return["\$route"],
                "route" => [
                    'method' => request()->method(),
                    'url' => request()->url(),
                    'fullUrl' => request()->fullUrl(),
                    'path' => request()->path(),
                    'pathInfo' => request()->getPathInfo(),
                ],
                "request" => request()->all(),
                // "layout" => $return["view"],
                // "view" => $return["view"],
                "logs" => $this->getLogs(),
            ]);
            return response()->json($return);
        } else {
            return $data;
        }
    }

    public function error($message = '失败')
    {
        // var_dump($message);
        artisan_dump($message);
        // Log::info('[' . request()->method() . '] ' . request()->fullUrl(), [
        //   // "attributes" => request()->attributes(),
        //   "request" => request()->all(),
        //   "query" => request()->query(),
        //   "server" => request()->server(),
        //   // "files" => request()->files() ?? [],
        //   "cookies" => request()->cookie(),
        //   "headers" => request()->header(),
        //   'response' => $message,
        //   'debug' => array_map(function ($item) {
        //     return ($item['class'] ?? '') . '::' . $item['function'] . '->' . $item['line'];
        //   }, debug_backtrace()),
        // ]);
        if ($this->isApiRoute() && $message instanceof \Exception) {
            //            $message = '[' . $message->getFile() . '::' . $message->getCode() . '::' . $message->getLine() . ']  ' . $message->getMessage();
            \Log::channel('mysql')->error(request()->getPathInfo(), [
                // "route" => $return["\$route"],
                "route" => [
                    'method' => request()->method(),
                    'url' => request()->url(),
                    'fullUrl' => request()->fullUrl(),
                    'path' => request()->path(),
                    'pathInfo' => request()->getPathInfo(),
                ],
                "request" => request()->all(),
                // "layout" => $return["view"],
                // "view" => $return["view"],
                "logs" => $this->getLogs(),
            ]);
            return response()->json([
                'status' => 400,
                'message' => $message->getMessage(),
                'file' => $message->getFile(),
                'code' => $message->getCode(),
                'line' => $message->getLine(),
                'logs' => $this->getLogs()
            ]);
        }
        return $message;
    }

    public function debug($data = [], $message = '调试')
    {
        Log::debug(request()->fullUrl());
        return response()->json([
            'status' => 500,
            'message' => $message,
            'data' => $data,
            // 'debug' => debug_backtrace(),
            // 'debug' => array_map(function ($item) {
            //     return ($item['class'] ?? '') . '::' . $item['function'] . '->' . $item['line'];
            // }, debug_backtrace()),
        ]);
    }

    /**
     * 由于请求接口调用的方法，可能嵌套调用，会造成多层结构，需清除
     */
    public function getReturn($return)
    {
        if ($this->isApiRoute() && $return instanceof JsonResponse) {
            if (isset($return->original['data'])) {
                return $return->original['data'];
            } else {
                return null;
            }
        }
        // if ($return instanceof Model) return $return->toArray();
        return $return;
    }

    public function each_key_method()
    {
    }

    public function call_self_method($key, ...$values)
    {
        if (!array_key_exists($key, $this->getKeyMap())) {
            return;
        }

        $method = $this->getKeyMap()[$key];
        if (!method_exists($this, $method)) {
            return;
        }

        return $this->{$method}(...$values);
    }

    public function each_item_func($method, Request $request)
    {
        try {
            // dump(__METHOD__);
            $model = $this->issetModel($request->input('$model', $this->BaseModel));
            $primaryKey = (new $model())->getKeyName();
            $parentColumn = (new $model())->parentColumn;
            // dump(__METHOD__, $primaryKey, $parentColumn);
            // dump(__METHOD__, $method);
            $return = [
                'data' => [],
                'success_count' => 0,
                'failed_count' => 0,
            ];
            foreach ($request->input('data', []) as $item) {
                $result = $this->getReturn($this->$method(new Request(array_merge($item, ['$model' => $model]))));
                if (isset($item['children']) && sizeof($item['children']) > 0 && !empty($parentColumn)) {
                    // var_dump(["call children each_item_func", $item['children']]);
                    // 递归调用 传参为子类数据
                    $resultChildren = $this->getReturn($this->each_item_func($method, new Request([
                        '$model' => $model,
                        'data' => array_map(function ($child) use ($result, $primaryKey, $parentColumn) {
                            return array_merge($child, [
                                $parentColumn => $result[$primaryKey],
                            ]);
                        }, $item['children']),
                    ])));
                    $result['children'] = $resultChildren['data'];
                }
                if (empty($result)) {
                    array_push($return['data'], null);
                    $return['failed_count']++;
                } else {
                    array_push($return['data'], $result);
                    $return['success_count']++;
                }
                unset($result);
            }
            return $this->success($return);
        } catch (Exception $e) {
            $this->error($e);
        }
    }

    public function proxy(Request $request)
    {
        $url = $request->filled('url') ? $request->input('url') : abort(404);
        $method = $request->filled('method') ? $request->input('method') : 'get';

        $response = Http::{$method}($url);

        echo $response->body();
    }
    public function registor(Request $request)
    {
    }
    public function login(Request $request)
    {
    }
    public function logout(Request $request)
    {
    }
    public function forget_password(Request $request)
    {
    }
}
