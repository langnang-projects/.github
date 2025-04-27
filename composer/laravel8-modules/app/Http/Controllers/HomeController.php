<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends \App\Illuminate\Routing\Controller
{
    public function view_index($midOrSlug = NULL)
    {
        return $this->view('welcome');
    }
    public function view_login()
    {
        if (request()->method() == 'POST') {
            $credentials = request()->only('email', 'password');
            if (Auth::attempt($credentials, true)) {
                // 认证通过．．．
                $user = \App\Models\User::where('email', $credentials['email'])
                    ->first();
                Auth::login($user, true);

                return redirect('/');
            } else {
                var_dump("登陆失败");
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
            }
        }
        return $this->view('master.auth.login');
    }
    public function view_register()
    {
        if (request()->method() == 'POST') {
            var_dump(request()->all());
        }
        return $this->view('master.auth.register');
    }
    public function view_verify()
    {
        if (request()->method() == 'POST') {
            var_dump(request()->all());
        }
        return $this->view('master.auth.verify');
    }
    public function view_confirm_password()
    {
        if (request()->method() == 'POST') {
            var_dump(request()->all());
        }
        return $this->view('master.auth.passwords.confirm');
    }
    public function view_email_password()
    {
        if (request()->method() == 'POST') {
            var_dump(request()->all());
        }
        return $this->view('master.auth.passwords.email');
    }
    public function view_reset_password()
    {
        if (request()->method() == 'POST') {
            var_dump(request()->all());
        }
        return $this->view('master.auth.passwords.reset');
    }
}
