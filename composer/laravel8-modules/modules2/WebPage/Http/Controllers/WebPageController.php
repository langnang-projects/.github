<?php

namespace Modules\WebPage\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Illuminate\Routing\Controller;

class WebPageController extends \App\Http\Controllers\Controller
{
    protected $contentModel = \Modules\WebPage\Models\WebPage::class;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function _index()
    {
        $return = [
            'content' => \App\Models\Content::factory()->times(1)->make()->first()
        ];
        $return['content']->dependencies = [
            ["name" => "bootstrap", "version" => "4.6.2", "type" => "css", "cdn" => "unpkg", "file" => "/dist/css/bootstrap.min.css", "url" => "https://unpkg.com/bootstrap@4.6.2/dist/css/bootstrap.min.css"],
            ["name" => "jquery", "version" => "3.7.1", "type" => "javascript", "cdn" => "unpkg", "file" => "/dist/jquery.slim.min.js", "url" => "https://unpkg.com/jquery@3.7.1/dist/jquery.slim.min.js"],
            ["name" => "bootstrap", "version" => "4.6.2", "type" => "javascript", "cdn" => "unpkg", "file" => "/dist/js/bootstrap.bundle.min.js", "url" => "https://unpkg.com/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"],
            ["name" => "feather-icons", "version" => "4.29.2", "type" => "javascript", "cdn" => "unpkg", "file" => "/dist/feather.min.js", "url" => "https://unpkg.com/feather-icons@4.29.2/dist/feather.min.js"],
            ["name" => "chart.js", "version" => "4.4.7", "type" => "javascript", "cdn" => "unpkg", "file" => "/dist/chart.umd.js", "url" => "https://unpkg.com/chart.js@4.4.7/dist/chart.umd.js"],
        ];
        $return['content']->style = '';
        $return['content']->script = '';
        // dump($return);
        return view('webpage::empty.index', $return);
    }
}
