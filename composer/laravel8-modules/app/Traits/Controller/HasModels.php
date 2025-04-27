<?php

namespace App\Traits\Controller;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait HasModels
{
    protected $models = [];

    public function getModels($path = null)
    {
        return $this->models;
    }
    public function setModels($models = [])
    {
        $this->models = array_merge(config('models.models'), $models);
    }

    public function queryBuilder($modelFunConfig)
    {
        $log = ["method" => __METHOD__, "arguments" => ["modelFunConfig" => $modelFunConfig]];
        $class = $modelFunConfig['class'];
        $query = $class::select();
        // var_dump($modelFunConfig);
        $query = $this->queueClauses($modelFunConfig, $query);
        // $query = $this->whereClauses($modelFunConfig, $query);
        // $query = $this->orderByClauses($modelFunConfig, $query);
        // $query = $this->groupByClauses($modelFunConfig, $query);
        $log['sql'] = $query->toSql();
        $this->prependLogs($log);
        return $query;
    }

    public function queueClauses($config, $query)
    {
        $log = ["method" => __METHOD__, "arguments" => ["config" => $config, "query" => $query], "keys" => [], "casts" => []];
        // var_dump($config);
        foreach (config('models.clauses.queue') ?? [] as $key) {
            if (array_key_exists($key, $config)) {
                // array_push($log['keys'], $key);
                $cast = config('models.clauses.casts.' . $key);
                $log["keys"][$key] = $config[$key];
                $log["casts"][$key] = $cast;
                if ($cast == 'array') {
                    // $log["keys"][$key] = array_filter($config[$key]);
                    $query = $query->{$key}(array_filter($config[$key]));
                } else if (!empty($config[$key])) {
                    $query = $query->{$key}(...$config[$key]);
                }
            }
        }
        $this->prependLogs($log);
        return $query;

    }
    public function selectClauses(Request $request)
    {
        return $request->input('$select', []);
    }

    /**
     * @description with 语句
     * @param Request $request
     * @return mixed
     */
    public function withClauses($config, $query)
    {
        $log = ["method" => __METHOD__, "arguments" => ["config" => $config, "query" => $query], "keys" => []];
        foreach (['with', 'without', 'withCount', 'withPivot', 'withTimestamps', 'morphWith', 'morphWithCount', 'withDefault', 'syncWithoutDetaching', // 获取包括软删除模型在内的模型
            'withTrashed', 'onlyTrashed', // 对当前查询取消全局作用域
            'withoutGlobalScope', // 暂时「禁用」模型触发的所有事件
            'withoutEvents',] as $key) {
            if (array_key_exists($key, $config)) {
                // array_push($log['keys'], $key);
                $log["keys"][$key] = $config[$key];
                $query = $query->{$key}($config[$key]);
            }
        }
        $this->prependLogs($log);
        return $query;

        // return $request->input('$with', []);
    }

    /**
     * @description where 语句
     * @param Request $request
     * * $where [[key, value]]
     * * $orWhere
     * * $whereIn [key => value]
     * * $orWhereIn
     * * $whereNotIn
     * * $orWhereNotIn
     * * $whereBetween
     * * $whereNotBetween
     * @param $return
     * @param array $ignores 过滤的列
     * @return mixed
     */
    public function whereClauses($config, $query, array $ignores = [])
    {
        $log = ["method" => __METHOD__, "arguments" => ["config" => $config, "query" => $query], "keys" => []];
        foreach (['where', 'orWhere', 'whereBetween', 'orWhereBetween', 'whereNotBetween', 'orWhereNotBetween', 'whereIn', 'orWhereIn', 'whereNotIn', 'orWhereNotIn', 'whereNull', 'whereNotNull', 'orWhereNull', 'orWhereNotNull', 'whereDate', 'whereMonth', 'whereDay', 'whereYear', 'whereTime', 'whereColumn', 'orWhereColumn', 'whereHasMorph',] as $clause) {

            if (array_key_exists($clause, $config)) {
                // array_push($log['keys'], $key);
                $conditions = $config[$clause];

                foreach ($conditions as $con_index => $condition) {
                    $column = $conditions[0];
                }

                $log["keys"][$clause] = $conditions;
                $query = $query->{$clause}($conditions);
            }

            // if (!$request->filled($clause)) {
            //     continue;
            // }

            // if (empty($request->input($clause))) {
            //     continue;
            // }

            // $args = $request->input($clause, []);
            // if (in_array($clause, ['$where'])) {
            //     $args = $request->input($clause, []);
            //     // dump($args);
            //     foreach ($args as $index => $arg) {
            //         // dump($arg[0]);
            //         if (in_array($arg[0], $ignores)) {
            //             unset($args[$index]);
            //         }
            //     }
            //     // dump($args);
            //     $args = [$args];
            // }
            // if (in_array($clause, ['$whereIn'])) {
            //     foreach ($request->input($clause) as $key => $value) {
            //         $return = $return->{substr($clause, 1)}($key, $value);
            //     }
            // } else {
            //     $return = $return->{substr($clause, 1)}(...$args);
            // }
        }
        // 存在 relationships 并非前置方法存入的空数据
        // if ($request->filled('relationships') && !empty($request->input('relationships'))) {
        //     $return = $return->whereHas('relationships', function (Builder $query) use ($request) {
        //         foreach ($request->input('relationships') as $key => $value) {
        //             if (is_array($value)) {
        //                 $query = $query->whereIn($key, $value);
        //             } else {
        //                 $query = $query->where($key, $value);
        //             }
        //         }
        //     });
        // }
        $this->prependLogs($log);
        return $query;
    }

    public function orderByClauses($config, $query)
    {
        $log = ["method" => __METHOD__, "arguments" => ["config" => $config, "query" => $query], "keys" => []];

        foreach (['orderBy',] as $key) {
            if (array_key_exists($key, $config)) {
                // array_push($log['keys'], $key);
                $log["keys"][$key] = $config[$key];
                $query = $query->{$key}(...$config[$key]);
            }
        }
        $this->prependLogs($log);
        return $query;

        // if ($request->filled('$order') && !empty($request->input('$order'))) {
        //     $order = $request->input('$order');
        //     if (is_array($order)) {
        //         foreach ($order as $args) {
        //             if (is_string($args)) {
        //                 $return = $return->orderBy($args, 'desc');
        //             } else {
        //                 $return = $return->orderBy(...$args);
        //             }
        //         }
        //     } else {
        //         $return = $return->orderBy($order);
        //     }
        //     unset($order);
        // }
        // return $return;
    }

    public function groupByClauses($config, $query)
    {
        return $query;
    }

    public function call_methods(Request $request, $methods = [], $return = [])
    {
        if (empty($methods))
            return $return;

        foreach ($methods as $methodConf) {
            $key = $methodConf[0];
            $method = $methodConf[1];
            $args = array_slice($methodConf, 2);
            // var_dump($args);
            $request->merge($return);
            $method_return = $this->getReturn($this->{$method}($request, ...$args));
            if (empty($key)) {
                // $this->{$method}($request);
                if (!empty($method_return))
                    $return = $method_return;
            } else
                $return[$key] = $method_return;
            // var_dump([$methodConf, $key]);
        }
        return $return;
    }
}
