<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function editprofile (){
        // to find and return id of the current user
        // find( auth() -> user() -> id)
        $admin = Admin::find( auth() -> user() -> id);
        return view('admin.profile.EditProfile', compact('admin'));
    }
    public function updateProfile(ProfileRequest $request, $id){

              try {
            // بقدر ارجع قيمة عمود محدد من الجدول بهاد الامر .. مثلا بدي ارجع id
            //auth('admin') ->user()->id; will return id of the user
            $admin = Admin::find($id); //retive data of this id as collection

            if ($request->filled('password')) { // يعني لو password input بيحتوي على قيمة
                $request->merge(['password' => bcrypt($request->password)]); // اعملي الها bcrypt ومن ثم ارسلها للداتابيز
            }


        //  $admin -> update($request ->only(['name','email'])); // only update (name + email)
            unset($request['id']);
            unset($request['password_confirmation']);
            $admin ->update($request ->all());// update all requests
            //يعني راح يعمل  update لكل الريكويستس اللي بتجيه سواء كانت كلها جاياه او بعضها
            // يعني مثلا يجيه الايميل والباسوورد لكن الاسم لا او ييجوا كلهم وهكذا
            //// هلقيت لازم اعمل unset لل id و password_confirmation يعني اعمللهم تجاهل
            // لانه انا عامل $request ->all()فمش راح اعمل insert لل id او password_confirmation
            //لانه id مش راح اعمل عليه تعديل في الداتا بيز
            // اما password_confirmation مش راح اخزمها لانه بس موجودة عشان تعمل مقارنة مع الباسوورد يعني للتاكيد

            return redirect()->back()->with(['success' => __('admin/alerts.updated successfully')]);
        }catch (\Exception $ex){
            return redirect()->back()->with(['errors' => 'there is a problem, please try again later']);
        }

    }
}
