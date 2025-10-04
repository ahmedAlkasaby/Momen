<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class StoreWishlistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('wishlists', 'product_id')->where(function ($query) {
                    return $query->where('user_id', Auth::guard('api')->id());
                }),
            ],

        ];
    }
    public function messages(): array
    {
        return [
            'product_id.required' => __('validation.product_required'),
            'product_id.exists' => __('validation.product_exists'),
            'product_id.unique' => __('validation.product_unique_in_wishlist'),
        ];
    }
}
