<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/market', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'market'], function () {

    Route::match (['post'], '/operate', '\Modules\Market\Http\Controllers\MarketAdminController@install_pipline');

    Route::match (['post'], '/jsdeliver', function (Request $request) {
        $client = new Client(['verify' => false]);
        $return = $request->all();
        $return['file_temp_path'] = $file_temp_path = storage_path('modules/' . pathinfo($return['url'])['basename']); //保存文件地址+原始文件名
        $filename = $return['pathinfo']['filename'];
        $return['headers'] = get_headers($return['url'], true);
        $return['size'] = empty ($return['headers']['Content-Length']) ? null : (is_array($return['headers']['Content-Length']) ? end($return['headers']['Content-Length']) : $return['headers']['Content-Length']);
        $return['headers'] = get_headers($return['url'], true);
        $return['streamInterval'] = 1024 * 100;

        switch ($return['operate']) {
            case "start":
                Storage::append('modules/.todo', $return['url']);
                Storage::put("modules/{$filename}.progress", $return['url'] . ' | ' . $return['size'] . ' | 0');
                // $return['progress'] = explode(PHP_EOL, Storage::get('modules/.progress'));
                // $return['progress'] = explode("\n", Storage::get('modules/.progress'));
                $return['byetRange'] = [-1, -1];
                // Storage::append('modules/.progress', $return['url'] . ' | ' . '0' . ' | ' . $return['size']);
                break;
            case "progress":
                // $tempData = $client->request('get', $return['url'])->getBody()->getContents();
                // Storage::put('modules/' . $pathinfo['basename'], $tempData); //文件保存地址
                $return['byetRange'][1] = empty ($return['size']) ? ($return['byetRange'][0] + $return['streamInterval']) : ($return['byetRange'][1] > $return['size'] ? $return['size'] : $return['byetRange'][1]);
                $progress = curl_download($return['url'], implode("-", $return['byetRange']));
                // $progress = curl_download($return['url'], implode("-", [0, 1]));
                Storage::append("modules/{$filename}.progress", $return['url'] . ' | ' . $return['size'] . ' | ' . implode("-", $return['byetRange']));
                Storage::append('modules/' . $pathinfo['basename'], $progress['stream']);
                break;
            case "pause":
                break;
            case "unzip":

                break;
            case "install":
                break;
            default:
                break;
        }

        return response()->json($return);
    });
    // 文件下载进度查询
    Route::match (['post'], '/progress', function (Request $request) {
        $return = $request->all();
        $return['pathinfo'] = $pathinfo = pathinfo($return['url']);
        $return['headers'] = get_headers($return['url'], true);
        $return['size'] = is_array($return['headers']['Content-Length']) ? end($return['headers']['Content-Length']) : $return['headers']['Content-Length'];
        $return['progress'] = Storage::size('modules/' . $pathinfo['basename']);
        return response()->json($return);
    });

    Route::match (['get'], '/test', function (Request $request) {
        $return = $request->all();
        $return['url'] = 'https://registry.npmjs.org/bootstrap-tour/-/bootstrap-tour-0.11.0.tgz';
        $pathinfo = pathinfo($return['url']);
        var_dump($pathinfo);
        $progress = curl_download($return['url'], implode("-", [0, 100000]));
        var_dump(md5($progress['stream']));

        Storage::put('modules/packages/' . $pathinfo['basename'], '');
        $progress_1 = curl_download($return['url'], implode("-", [0, 10000]));
        // Storage::append('modules/packages/' . $pathinfo['basename'], $progress_1['stream']);
        // file_put_contents(storage_path('modules/packages/' . $pathinfo['basename']), $progress_1['stream'], FILE_APPEND);
        file_put_contents($pathinfo['basename'], $progress_1['stream'], FILE_APPEND);

        $progress_2 = curl_download($return['url'], implode("-", [10001, 100000]));
        // Storage::append('modules/packages/' . $pathinfo['basename'], $progress_2['stream']);
        // file_put_contents(storage_path('modules/packages/' . $pathinfo['basename']), $progress_2['stream'], FILE_APPEND);
        file_put_contents($pathinfo['basename'], $progress_2['stream'], FILE_APPEND);
        // $return['file_size'] = Storage::size('modules/packages/' . $pathinfo['basename']);
        $return['file_size'] = filesize($pathinfo['basename']);
        // $return['file_md5'] = md5_file(storage_path('app/modules/packages/' . $pathinfo['basename']));
        $return['file_md5'] = md5_file($pathinfo['basename']);
        var_dump(base_path($pathinfo['basename']));
        var_dump(Storage::path('file.jpg'));
        var_dump(md5($progress_1['stream'] . $progress_2['stream']));
        var_dump($return['file_size']);
        var_dump($return['file_md5']);

        // $pathinfo = pathinfo($return['url']);
        // var_dump(storage_path('app/modules/packages/' . $pathinfo['basename']));
        // var_dump(storage_path('app/modules/packages/' . $pathinfo['filename']));
        // // unzip(storage_path('app/modules/packages/' . $pathinfo['basename']), storage_path('app/modules/packages/' . $pathinfo['filename']));

        // UnifiedArchive::open(storage_path('app/modules/packages/' . $pathinfo['basename']))->extract(storage_path('app/modules/packages/' . $pathinfo['filename']));
        // unzip($pathinfo['basename'], storage_path('app/modules/packages/' . $pathinfo['filename']));
        // $urls = [
        //   'https://registry.npmjs.org/bootstrap/-/bootstrap-4.0.0-alpha.6.tgz',
        //   'https://registry.npmjs.org/vue-scrollto/-/vue-scrollto-2.20.0.tgz',
        //   'https://registry.npmjs.org/bootstrap-vue/-/bootstrap-vue-2.23.1.tgz',
        //   'https://registry.npmjs.org/vue/-/vue-3.3.4.tgz',
        //   'https://registry.npmjs.org/glyphicons-only-bootstrap/-/glyphicons-only-bootstrap-1.0.1.tgz'
        // ];
        // $return['url'] = $urls[1];
        // $return['headers'] = curl_headers($return['url']);
        // $return['pathinfo'] = $pathinfo = pathinfo($return['url']);
        // Storage::delete('modules/' . $pathinfo['basename']);
        // $progress = curl_download($return['url'], implode("-", [0, 100000]), $return['headers']);
        // Storage::append('modules/' . $pathinfo['basename'], $progress['stream']);
        // $progress = curl_download($return['url'], implode("-", [100001, PHP_INT_MAX]), $return['headers']);
        // Storage::append('modules/' . $pathinfo['basename'], $progress['stream']);
        // // $progress = curl_download($return['url'], implode("-", [10000, 500000]));
        // // Storage::append('modules/' . $pathinfo['basename'], $progress['stream']);
        // // ob_clean();
        // // flush();
        // $return['md5'] = md5_file(storage_path('app/modules/' . $pathinfo['basename']));
        // $return['temp_md5'] = md5_file(storage_path('app/modules/bootstrap-4.0.0-alpha.6.temp.tgz'));
        // // var_dump($return);
        // return response()->json($return);
    });
});
