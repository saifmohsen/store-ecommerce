<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingsRequest extends FormRequest
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
            'id' => 'required|exists:settings', // ال exists:settings معناها انها لازم تكون موحجة في جدول settings
            'value' => 'required',
            'plain_value' => 'nullable|numeric', // it can be required or may can be null

        ];
    }
    //هلقيت لو طلع عندي خطأ راح يعرض رسالة الخطأ اللي عاملاها لارافيل
    //ف انا بدي اعمل رسالة مخصصة زي مبدي

    public function messages()
    {
        return [
            'id.required'    => 'Please enter your id ',
            'id.exists'    => 'ID should be exist',
            'value.required'       => 'please enter the value',
            'plain_value.numeric' => 'the plan-value should be numeric',
        ];
    }
}
