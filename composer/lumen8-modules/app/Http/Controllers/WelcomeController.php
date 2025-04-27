<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nwidart\Modules\Facades\Module;

class WelcomeController extends \Laravel\Lumen\Routing\Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    /**
     * Show the application dashboard.
     *
     * @return
     */
    public function index(Request $request)
    {
        $return = [
            'view' => 'welcome',
            'modules' => [],
            'layouts' => [],
            'components' => [],
            'languages' => [],
        ];
        return view('welcome', $return);
    }
}