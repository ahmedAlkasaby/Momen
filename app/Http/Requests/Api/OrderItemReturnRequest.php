<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemReturnRequest extends FormRequest
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
            'order_item_id' => 'required|exists:order_items,id|unique:order_item_returns,order_item_id,except,id',
            'reason_id' => 'required|exists:reasons,id',
            'amount' => 'required|numeric',
            'image' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'note' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'order_item_id.unique' => __('validation.order_item_return_exists'),
        ];
    }
}
