<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;

class LoginController extends Controller
{
    public function login(){
        return view('admin.auth.login');
    }
    public function CheckAdminLogin(AdminLoginRequest $request){
        // دايما لما يكون في عندي فورم تسجيل دخول او تسجيل او اي فورم لازم اعمل فاليديشن بالاول
       //AdminLoginRequest//وطبعا الافضل اني اعمل الفاليديشن بملف لحاله مش هان يعني اعمل ملف ريكويست جديد وليكن اسمه
        //هاي عشان لما يعمل تذكرني يحفظ البيانات
    $remember_me = $request->has('remember_me') ? true : false;
            //راح نبحث في القارد اللي اسمه ادمن
        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {
            //attempt بتاخد الحاجات اللي انا بدخل فيها او االلي بحطها في فورمة تسجيل الدخول
            //attempt هاي الميثود بتروح بتجيب البيانات اللي بالقارد وبتقارنها مع اللي جاية من الريكويست
            //وبتعمل للبسوورد اللي جاية من الريكويست هاش عشان تقدر تقارنها مع اللي بالداتابيز
            //$remember_me بحطها في الكوكيز عشان يضل متذكر الدخول
            // notify()->success('تم الدخول بنجاح  ');
            return redirect() -> route('Admin.dashboard');
        }
       // notify()->error('خطا في البيانات  برجاء المجاولة مجدا ');
        return redirect()->back()->with(['error' => 'هناك خطا بالبيانات']);
        //طبعا الwith هاي بقدر اخزن من حلالها البيانات قي السشن
        // with store data in session , for example error will be stored in the session
        // لو كان في خطأ في البيانات راح يصل للايور ويخزنها بالسيشن وبالتالي يمكن استخدامها
        // ف بروح ع ملف الاليرتس في الفيوز وبعمل ملف للسكسس وللايرور وبعمل سشن وبعمللهن include
        // error file will be included in the login page because if there a mistake will appear in the same page
        // success file will be included in the next page for cuurent request
    }

}
