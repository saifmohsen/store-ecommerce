<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryRequest extends FormRequest
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
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$this -> id, //طبعا بينفع استخدمه لل store
            //يعني في حالة store راح يعتبر this -> id مش موجودة لانه مش عامل hidden input لل id في فورم ال store
        // اما في حالة update في عندي this -> id لانه في عندي hidden input فلازم احطه هان
            //طبعا عشان في store لازم يكون unique ع مستوى الجدول
            // اما في update لازم يكون unique ع مستوى الجدول ما عدا لهاد id لانه ممكن ميغيرش كل input فبينفع يكون مكرر لما يعمل ارسال
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'هذا الاسم مطلوب',
            'slug.required' => 'يجب ادخال الاسم بالرابط',
            'slug.unique'   => 'هذا الاسم موجود مسبقا',
        ];
    }

}
