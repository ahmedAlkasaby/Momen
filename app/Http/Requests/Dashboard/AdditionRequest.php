<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdditionRequest extends FormRequest
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
            "description.en" => "nullable|string|max:1000",
            "description.ar" => "nullable|string|max:1000",
            "active" => "boolean",
            "order_id" => "nullable|integer",
            "image" => "nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048",
            'type' => ['required', Rule::in(['free', 'paid'])],
            "price" => "required|numeric",
        ];
    }
    public function messages(): array
    {
        return [
            "name.ar.required" => __("validation.name_ar_required"),
            "name.en.required" => __("validation.name_en_required"),
            "description.en.max" => __("validation.description_en_max", ["max" => 1000]),
            "description.ar.max" => __("validation.description_ar_max", ["max" => 1000]),
            "active.boolean" => __("validation.active_boolean"),
            "order_id.exists" => __("validation.order_id_required"),
            "image.image" => __("validation.image_image"),
            "image.mimes" => __("validation.image_mimes", ["mimes" => "jpg,jpeg,png,gif,webp"]),
            "image.max" => __("validation.image_max", ["max" => 2048]),
            "type.required" => __("validation.type_required"),
            "price.required" => __("validation.price_required"),
            "price.numeric" => __("validation.price_numeric"),
        ];
    }
}
