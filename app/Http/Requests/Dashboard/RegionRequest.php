<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class RegionRequest extends FormRequest
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
            'name.ar' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
            'active' => 'required|boolean',
            "order_id" => "nullable|integer",
            "city_id" => "required|exists:cities,id",
            "shipping" => "required|numeric",
        ];
    }

    public function message(){
        return [
            "name.ar.required" => __("validation.name_ar_required"),
            "name.en.required" => __("validation.name_en_required"),
            "active.required" => __("validation.active_required"),
            "active.boolean" => __("validation.boolean"),
            "order_id.exists" => __("validation.order_id_required"),
            "city_id.exists" => __("validation.city_id_required"),
            "shipping.required" => __("validation.shipping_required"),
            "shipping.numeric" => __("validation.shipping_numeric"),
        ];
    }
}
