<?php

namespace App\Http\Requests\Api;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreCartItemsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {

        return [
            'product_id' => ['required', 'exists:products,id'],
            'amount' => [
                'required',
                'integer',
                'min:1',

            ],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => __('validation.required',['attribute'=>'product_id']),
            'product_id.exists'   => __('validation.exists',['attribute'=>'product_id']),
            'amount.required' => __('validation.required',['attribute'=>'amount']),
            'amount.integer' => __('validation.integer',['attribute'=>'amount']),
            'amount.min' => __('validation.min.numeric',['attribute'=>'amount','min:1']),

        ];
    }

}
