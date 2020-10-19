<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if ($guard == 'admin')
                return redirect(RouteServiceProvider::ADMIN); // لو هو عامل تسجيل دخول خليني في الصفحة اللي انا فيها
             // طبعا المتغير ADMIN  بنضيفو في ملف الRouteServiceProvider يعني بنضغط ctrul وبالماوس على اسم الملف اللي هان
            else
            return redirect(RouteServiceProvider::HOME); //لو هو مش عامل رجعني على الصفحة الرئيسية
        }

        return $next($request);
    }
}
