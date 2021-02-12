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
            if (Request::is( app() ->getLocale().'/admin*')) // if request (route) contain admin, and he is not log in to system, then return to admin login
                 // طبعا admin*/ هاي معناها بداية الراوت راح يكون في admin
                // فراح يرجعني لل admin login
                // لكن عشان انا مستخدم تعدد اللغات فراح يضيف عندي مثلا ar , en وهكذا حسب اللغة الموجودة قبل كلمة admin
                //عشان هيك لازم اضيف امر ()app.getlocal عشان يضيف اختصار اللغة قبل كلمة admin في url
                return route('admin.login');
             else // اما لو الراوت لا يحتوي على كلمة admin ومش عامل تسجيل دخول رجعه على الصفحة تسجيل الدخول الخاصة باليوزر
                return route('login');
        }
    }
}
