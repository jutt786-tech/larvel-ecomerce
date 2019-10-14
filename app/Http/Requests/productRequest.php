<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productRequest extends FormRequest
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
            'pname' => 'required|max:255',
            'description' => 'required',
            "price" => 'required',
            "discount" => 'required',
            "discount_price" => 'required',
            'img'   =>  'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
