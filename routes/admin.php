<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// namespace is the path or name of the controller folder for multiple contoller inside the same folder
// هلقيت عشان اقدر اصل لاي روت هان لازم اكون عامل تسجيل دخول او اكون شخص اوثينتيكيت لاني عامل ميدلوير
//يعني لو فتحت اي رابط من هان ومش عامل دخول راح يوديني لصفحة تسجيل الدخوب
//وانا عندي صفحتين تسجيل دخول وحدة للادمن والتانية لليوزر
//فانا بروح ع الميدلوير اللي اسمه Authentication وبعمل فيه انه لو يوجد بالرابط اللي هو الروت كلمة ادمن رجعني ع صفحة تسجيل الدخول تعت الادمن
//غير هيك رجعني ع صفحة تسجيل الدخول الخاصة باليوزر
Route::group(
    ['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function(){
    Route::group(['namespace' => 'Admin', 'middleware' => 'auth:admin', 'prefix' => 'admin'], function () {
        Route::get('/', 'DashboardController@index')->name('Admin.dashboard');
        Route::get('logout','LoginController@logout')->name('admin.logout');
        Route::get('logout','LoginController@logout')->name('admin.logout');
        // to logout you must be authenticatd admin and logged in
        Route::group(['prefix' => 'profile'], function (){
            Route::get('edti', 'ProfileController@editprofile')->name('edit.profile');
            Route::put('update/{id}', 'ProfileController@updateProfile')->name('update.profile');
        });
        Route::group(['prefix' => 'settings'], function (){
            Route::get('shipping-methods/{type}', 'SettingController@shippingMethods')->name('get.shipping.methods');
            Route::put('shipping-methods/{id}', 'SettingController@UpdateShippingMethods')->name('update.shipping.methods');
        });
        ################################# Categires Routes ################################
        Route::resource('main-categories', 'MainCategoriesController')->except([
             'update' // يعنيRoute put مش راح يكون ضمن resource فانا عملت استثناء لهاي الميثود الخاصة بهاد الراوت
        ]); // لكن بقدر استخدمها ل Route زي منا عاملها تحت
        Route::put('main-categories/{id}','MainCategoriesController@update')->name('admin.main-categories.update');
        ################################# End Of Categires Routes ################################

        ################################# Sub-Categires Routes ################################
        Route::resource('sub-categories', 'SubCategoriesController');
       // Route::put('main-categories/{id}','MainCategoriesController@update')->name('admin.main-categories.update');
        ################################# End Of Sub-Categires Routes ################################


    });
// هان الصفحات اللي مش لازم يكون عليهن ميدلوير زي صفحة تسجيل الدخول
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
        //'guest:admin حطيناه هان انه لو كان الادمن عامل تسجيل دخول وراح كتب روت صفحة الدخول مش راح يوديه عليها وراح يرجعه ع الصحفحة اللي هو فيها
        //guest:admin //auth عشان يكون اي حد يقدر يزورها ف بينفعش احط  guest طبعان هان حطينا
        Route::get('login', 'LoginController@login')->name('admin.login'); //return admin login page
        //هلقيت لما اضغط تسجيل الدخول لازم اودي البيانات ع رابط عشان يتأكد ويفخص اذا موجودة بالداتابيز او لا
        // ف بعمل رابط جديد عشان يتاكد من صحى البيانات واذا صح بيوديني ع الصفحة المطلوبة غير هيك بيرجعه ع اللوقين
        Route::post('login', 'LoginController@CheckAdminLogin')->name('check.admin.login');
        // it is normal to use "login" in tow routes because one is get and the other is post
    });
});

