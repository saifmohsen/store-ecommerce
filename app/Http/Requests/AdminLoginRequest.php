<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //اي واحد بزور الكلام هاد بيكونauthorize
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
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
    //هلقيت لو طلع عندي خطأ راح يعرض رسالة الخطأ اللي عاملاها لارافيل
    //ف انا بدي اعمل رسالة مخصصة زي مبدي

    public function messages()
    {
        return [
            'email.required'    => 'يجب ادخال البريد الالكتروني', //لو الايميل مش مدخل راخ تطلع هاي الرسالة وهكذا
            'email.email'       => 'صيغة البريد الالكتروني غير صحيحة',
            'password.required' => 'يجب ادخال كلمة السر '
        ];
    }
}
