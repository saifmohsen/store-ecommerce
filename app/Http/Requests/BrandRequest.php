<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'photo' => 'required_without:id|mimes:jpg,jpeg,png'
            // ال required_without:id معناها انه لو جاي في request مدخل او input id فمش راح تكون required
            // اما لو مش جاي  في request مدخل او input id ف راح تكون required
            // عشان هيك في صفحة create مش عاملين hidden input id بينما في صفحة edit عاملين hidden input id
        ];
    }
}
