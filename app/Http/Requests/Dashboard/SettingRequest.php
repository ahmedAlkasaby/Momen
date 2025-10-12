<?php

namespace App\Http\Requests\Dashboard;

use App\Helpers\ResultHelper;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            "site_title" => "required|string|max:255",
            "site_phone" => "required|string|size:11",
            "site_email" => "required|email",
            "min_order" => "required|numeric",
            "max_order" => "required|numeric",
            "delivery_cost" => "required|numeric",
            "site_open" => "required|boolean",
            "logo" => "nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048",
            'result' => 'required|integer|in:' . implode(',', array_keys(ResultHelper::getResultOptions())),

        ];
    }
    public function message(){
        return [
            "site_title.required" => __('validation.required', ['attribute' => 'Site Title']),
            "site_title.string" => __('validation.string', ['attribute' => 'Site Title']),
            "site_phone.required" => __('validation.required', ['attribute' => 'Site Phone']),
            "site_phone.string" => __('validation.string', ['attribute' => 'Site Phone']),
            "site_phone.length" => __('validation.length', ['attribute' => 'Site Phone']),
            "site_email.required" => __('validation.required', ['attribute' => 'Site Email']),
            "site_email.email" => __('validation.email', ['attribute' => 'Site Email']),
            "min_order.required" => __('validation.required', ['attribute' => 'Min Order']),
            "min_order.numeric" => __('validation.numeric', ['attribute' => 'Min Order']),
            "max_order.required" => __('validation.required', ['attribute' => 'Max Order']),
            "max_order.numeric" => __('validation.numeric', ['attribute' => 'Max Order']),
            "min_order_for_shipping_free.required" => __('validation.required', ['attribute' => 'Min Order For Shipping Free']),
            "min_order_for_shipping_free.numeric" => __('validation.numeric', ['attribute' => 'Min Order For Shipping Free']),
            "delivery_cost.required" => __('validation.required', ['attribute' => 'delivery Cost']),
            "delivery_cost.numeric" => __('validation.numeric', ['attribute' => 'delivery Cost']),
            "site_open.required" => __('validation.required', ['attribute' => 'Site Open']),
            "site_open.boolean" => __('validation.boolean', ['attribute' => 'Site Open']),
            "active.required" => __('validation.required', ['attribute' => 'Active']),
            "active.boolean" => __('validation.boolean', ['attribute' => 'Active']),
        ];
            
    }
}
