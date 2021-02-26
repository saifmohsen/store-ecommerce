<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //هان بحط الشغلات اللي بدي اعمللها فاليديشن واتاكد منها
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$this -> id,
            'password'  => 'nullable|confirmed|min:8',
            // unique:admins,email
            // هاي معناها انه الايميل لازم يكون unique في جدول الادمن في عمود اسمه email
            //   'email' => 'required|email|unique:admins,email,'.$this -> id,
            // هان انا حطيت .$this -> id معناها انه تجاهل الايميل الخاص بهاد id
            // عشان لو مبدهش يغير الايميل فراحص يضل زي مهو
            // فبالتالي م يقلي انه هاد الاميلي موجود مسبقا
            // باختصار unique:admins,email,'.$this -> id معناها انه email لازم يكون unique ما عدا لهاد id
            //يعني لو دخل نفس الايميل اللي هو مستخدمه مش راح يظهر اي خطأ
            // اما لو دخل ايميل لشخص اخر راح تظهرله رسالة انه هاد الايميل مستخد
        ];
    }
    //هلقيت لو طلع عندي خطأ راح يعرض رسالة الخطأ اللي عاملاها لارافيل
    //ف انا بدي اعمل رسالة مخصصة زي مبدي

    public function messages()
    {
        return [
            'name.required'      => 'يجب ادخال الاسم ',
            'email.required'     => 'يجب ادخال البريد الالكتروني', //لو الايميل مش مدخل راخ تطلع هاي الرسالة وهكذا
            'email.email'        => 'صيغة البريد الالكتروني غير صحيحة',
            'email.unique'       => 'مدخل مسبقا',
        ];
    }
}
