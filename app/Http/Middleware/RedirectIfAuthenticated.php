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
                return redirect(RouteServiceProvider::ADMIN); // لو هو عامل تسجيل دخول وروحت كتبت راوت login  خليني في الصفحة اللي انا فيها ومش راح يوديني ع صفحة تسجيل الدخول لاني في الاصل عامل تسجيل دخول
             // طبعا المتغير ADMIN  بنضيفو في ملف الRouteServiceProvider يعني بنضغط ctrul وبالماوس على اسم الملف اللي هان
         // طبعا لازم اعمل middleware' => 'guest:admin للراوت اللي اسمه login والراوت اللي بيفحص عملية تسجيد دخول
            else
            return redirect(RouteServiceProvider::HOME); //لو مكنش ال guard هو admin وكنت عامل تسجيل دخول ك user مثلا وروحت كتبت راوت ال login رجعني على الصفحة الرئيسية او اللي انا فيها
        }

        return $next($request);
    }
}
