<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
//            'tracking_code' => 'required|unique:trackings|max:55',
            "items" => ["required","array","min:1","max:1000"],
            'items.*.category' => 'required',
            'items.*.shipping_price' => 'required',
            'items.*.price.*' => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ]));

    }


    public function messages() {
        return [
            'tracking_code.required' => 'tracking_code is required',
            'tracking_code.unique' => 'tracking_code is must be unique',
            'tracking_code.max' => 'tracking_code is must be max 55 characters',
            'category.required' => 'category is required',
            'shipping_price.required' => 'shipping_price is required',
            'price.required' => 'price is required',
        ];
    }
}
