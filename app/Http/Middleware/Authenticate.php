<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) { //if he is not log in
            if (Request::is('admin/*')) // if request (route) contain admin, and he is not log in to system, then return to admin login
                return route('admin.login');
             else // اما لو الراوت لا يحتوي على كلمة admin ومش عامل تسجيل دخول رجعه على الصفحة تسجيل الدخول الخاصة باليوزر
                return route('login');
        }
    }
}
