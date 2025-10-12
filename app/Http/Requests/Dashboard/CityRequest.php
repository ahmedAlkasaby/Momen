<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
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
            "name.ar" => "required|string|max:255",
            "name.en" => "required|string|max:255",
            "shipping"=>"required|numeric",
            "active" => "required|boolean",
            "order_id" => "nullable|integer",
        ];
    }

    public function messages()
    {
        return [
            'shipping.required' => __('validation.required', ['attribute' => 'Shipping']),
            "active.required" => __('validation.required', ['attribute' => 'Active']),
            "name.ar.required" => __('validation.required', ['attribute' => 'Arabic Name']),
            "name.en.required" => __('validation.required', ['attribute' => 'English Name']),
            "order_id.integer" => __('validation.integer', ['attribute' => 'Order']),
            "order_id.required" => __('validation.required', ['attribute' => 'Order']),
        ];
    }
}
