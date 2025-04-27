<?php

use Modules\WebSpider\Http\Controllers\WebSpiderController;

Route::prefix(config('this.alias'))->group(function () {
  Route::get('', [WebSpiderController::class, 'index']);
  Route::get('content', '\Modules\WebSpider\Http\Controllers\WebSpiderController@content');
  Route::get('ob-spider', '\Modules\WebSpider\Http\Controllers\WebSpiderController@ob_spider');
});
